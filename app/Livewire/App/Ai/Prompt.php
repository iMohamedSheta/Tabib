<?php

declare(strict_types=1);

namespace App\Livewire\App\Ai;

use App\Enums\Ai\AiModelEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Enums\Message\MessageTypeEnum;
use App\Models\Prompt as PromptModel;
use EchoLabs\Prism\Prism;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Prompt extends Component
{
    public string $prompt = '';
    public array $messages = [];

    public ?PromptModel $promptModel = null;

    public function mount(): void
    {
        // Add a welcome message
        $this->messages[] = [
            'type' => 'ai',
            'message' => 'مرحبا! كيف يمكنني مساعدتك؟',
        ];

        $this->promptModel = PromptModel::find(
            2
        );
        if (!is_null($this->promptModel)) {
            foreach ($this->promptModel->messages()->get() as $message) {
                if ($message->type === MessageTypeEnum::ANSWER->value) {
                    $messageType = 'ai';
                } elseif ($message->type === MessageTypeEnum::QUESTION->value) {
                    $messageType = 'user';
                } else {
                    $messageType = 'system';
                }

                $this->messages[] = [
                    'type' => $messageType,
                    'message' => $message->message,
                ];
            }
        }
    }

    public function send(): void
    {
        $this->validate([
            'prompt' => ['required', 'string', 'max:2048'],
        ], [], [
            'prompt' => 'الرسالة',
        ]);

        $prompt = $this->prompt;

        if (is_null($this->promptModel)) {
            $this->promptModel = PromptModel::create([
                'name' => substr($prompt, 0, 50),
            ]);
        }

        $this->prompt = '';

        $this->messages[] = [
            'type' => 'user',
            'message' => $prompt,
        ];

        $this->promptModel->messages()
            ->create([
                'type' => MessageTypeEnum::QUESTION->value,
                'message' => $prompt,
            ]);

        $this->dispatch('generate-prompt', $prompt)->self();
    }

    // #[On('generate-prompt')]
    public function generatePrompt(string $prompt): void
    {
        Validator::make([
            'prompt' => $prompt,
        ], [
            'prompt' => ['required', 'string', 'max:2048'],
        ], [], [
            'prompt' => 'الرسالة',
        ]);

        try {
            // Define the maximum number of messages to keep in the conversation history
            $maxMessages = 10;

            // Create a new array to hold the recent conversation history
            $recentMessages = array_slice($this->messages, -$maxMessages);

            // Build the conversation history from the recent messages
            $conversationHistory = '';
            foreach ($recentMessages as $message) {
                if ('user' === $message['type']) {
                    $conversationHistory .= $message['message'] . "\n";
                } elseif ('ai' === $message['type']) {
                    $conversationHistory .= $message['message'] . "\n";
                }
            }

            // Communicate with the AI through Prism, sending the conversation history
            $prism = Prism::text()
                ->withSystemPrompt(SystemPromptEnum::DEFAULT->prompt() . "\n here is the conversation history: \n" . $conversationHistory . "\n" . 'User: ' . SystemPromptEnum::AUTH->prompt() . "\n")
                ->using('custom.gemini_1', AiModelEnum::GEMINI_2_0_FLASH_EXP->value)
                ->usingProviderConfig([
                    'temperature' => 1,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                    'responseMimeType' => 'text/plain',
                ])
                ->withPrompt($prompt);

            $response = $prism->generate();
            $responseMessage = $response->text;

            // Store the response in the database
            if (!blank($responseMessage)) {
                $this->promptModel->messages()
                    ->create([
                        'type' => MessageTypeEnum::ANSWER->value,
                        'message' => Str::markdown($responseMessage),
                    ]);
            } else {
                $responseMessage = 'حدث خطاء في معالجة طلبك. يرجى المحاولة مرة أخرى.';
            }

            // Add AI response to the conversation
            $this->messages[] = [
                'type' => 'ai',
                'message' => $responseMessage,
            ];

            $this->dispatch('prompt-generated');
        } catch (\Exception $e) {
            log_error($e);

            $this->messages[] = [
                'type' => 'error',
                'message' => 'حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى.',
            ];

            flash()->error(__('alerts.error'));
        }
    }

    #[On('generate-prompt')]
    public function generateProgrammingPrompt(): void
    {
        // Validator::make([
        //     'prompt' => $prompt,
        // ], [
        //     'prompt' => ['required', 'string', 'max:2048'],
        // ], [], [
        //     'prompt' => 'الرسالة',
        // ]);

        try {
            $folderPath = base_path('app\Actions'); // Set your folder path

            // Define the maximum number of messages to keep in the conversation history
            $maxMessages = 3;

            // Create a new array to hold the recent conversation history
            $recentMessages = array_slice($this->messages, -$maxMessages);

            // Build the conversation history from the recent messages
            $conversationHistory = '';
            foreach ($recentMessages as $message) {
                if ('user' === $message['type']) {
                    $conversationHistory .= $message['message'] . "\n";
                } elseif ('ai' === $message['type']) {
                    $conversationHistory .= $message['message'] . "\n";
                }
            }

            // Communicate with the AI through Prism, sending the conversation history
            $files = File::allFiles($folderPath); // Get all files in the folder
            $filesContents = '';

            foreach ($files as $file) {
                $filesContents .= '### File: ' . $file->getFilename() . " ###\n";
                $filesContents .= File::get($file->getPathname()) . "\n\n";
            }

            // Define the AI prompt
            $prompt = "these are the files to create the docs for :\n\n" . $filesContents;

            $prism = Prism::text()
                ->withSystemPrompt(SystemPromptEnum::DOCUMENTATION->prompt())
                ->using('custom.gemini_1', AiModelEnum::GEMINI_2_0_FLASH_EXP->value)
                ->usingProviderConfig([
                    'temperature' => 1,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                    'responseMimeType' => 'text/plain',
                ])
                ->withPrompt($prompt);

            $response = $prism->generate();
            $responseMessage = $response->text;

            // Store the response in the database
            if (!blank($responseMessage)) {
                $this->promptModel->messages()
                    ->create([
                        'type' => MessageTypeEnum::ANSWER->value,
                        'message' => Str::markdown($responseMessage),
                    ]);
            } else {
                $responseMessage = 'حدث خطاء في معالجة طلبك. يرجى المحاولة مرة أخرى.';
            }

            // Add AI response to the conversation
            $this->messages[] = [
                'type' => 'ai',
                'message' => $responseMessage,
            ];

            $this->dispatch('prompt-generated');
        } catch (\Exception $e) {
            log_error($e);

            $this->messages[] = [
                'type' => 'error',
                'message' => 'حدث خطأ أثناء معالجة طلبك. يرجى المحاولة مرة أخرى.',
            ];

            flash()->error(__('alerts.error'));
        }
    }

    public function render()
    {
        return view('livewire.app.ai.prompt', [
            'messages' => $this->messages,
        ]);
    }
}
