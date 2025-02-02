<?php

declare(strict_types=1);

namespace App\Livewire\App\Ai;

use App\Enums\Ai\AiModelEnum;
use App\Enums\Ai\PromptMessageEnum;
use App\Enums\Ai\PromptTopicEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Enums\Message\MessageTypeEnum;
use App\Models\Prompt as PromptModel;
use EchoLabs\Prism\Enums\FinishReason;
use EchoLabs\Prism\Prism;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Mews\Purifier\Facades\Purifier;

class Prompt extends Component
{
    public string $prompt = '';
    public array $messages = [];
    public $promptModels = [];
    public ?PromptModel $sessionGeneratedPrompt = null;

    public ?PromptModel $promptModel = null;
    public array $topics = [];

    public array $topicsChecked = [];

    public function mount(): void
    {
        $this->messages[] = [
            'type' => 'ai',
            'message' => PromptMessageEnum::WELCOME->prompt(),
        ];

        $this->promptModels = PromptModel::latest()->select('id', 'name')->get();

        $this->topics = PromptTopicEnum::getTopicOptions();

        $this->topicsChecked = [
            PromptTopicEnum::PATIENT->value => true,
        ];
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
                'name' => Str::limit($prompt, 50),
            ]);

            $this->sessionGeneratedPrompt = $this->promptModel;
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

    #[On('generate-prompt')]
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
                ->withSystemPrompt(SystemPromptEnum::DEFAULT->prompt() . "\n here is the conversation history: \n" . $conversationHistory . "\n" . 'User: ' . SystemPromptEnum::AUTH->prompt() . "\n"
                    . "\n" . $this->getAdditionalPromptTopics())
                ->using('custom.gemini_1', AiModelEnum::LEARNLM_1_5_PRO_EXPERIMENTAL->value)
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
            if (!blank($responseMessage) && FinishReason::Stop === $response->finishReason) {
                $cleanResponseMessage = Purifier::clean(Str::markdown($responseMessage));

                $this->promptModel->messages()
                    ->create([
                        'type' => MessageTypeEnum::ANSWER->value,
                        'message' => $cleanResponseMessage,
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

    public function setPromptModel(?int $promptModelId = null): void
    {
        $promptModel = PromptModel::find($promptModelId);

        $this->messages = [];

        if (null === $promptModel && null === $this->sessionGeneratedPrompt) {
            $this->promptModel = null;
        } elseif (null === $promptModel && null !== $this->sessionGeneratedPrompt) {
            $this->promptModel = $this->sessionGeneratedPrompt;
        } else {
            $this->promptModel = $promptModel;
        }

        $this->dispatch('prompt-model-changed');
    }

    public function render()
    {
        $this->messages = [];
        $this->messages[] = [
            'type' => 'ai',
            'message' => PromptMessageEnum::WELCOME->prompt(),
        ];

        if (null !== $this->promptModel) {
            $this->messages = [
                ...$this->messages,
                ...$this->promptModel->ai_context,
            ];
        }

        return view('livewire.app.ai.prompt');
    }

    private function getAdditionalPromptTopics(): string
    {
        $additionalPrompt = '';

        if (!blank($this->topicsChecked)) {
            $topicsCheckedKeys = array_keys($this->topicsChecked);

            if (in_array(PromptTopicEnum::PATIENT->value, $topicsCheckedKeys)) {
                $additionalPrompt .= PromptTopicEnum::PATIENT->prompt();
            } elseif (in_array(PromptTopicEnum::APPOINTMENT->value, $topicsCheckedKeys)) {
                $additionalPrompt .= PromptTopicEnum::APPOINTMENT->prompt();
            } elseif (in_array(PromptTopicEnum::INVOICE->value, $topicsCheckedKeys)) {
                $additionalPrompt .= PromptTopicEnum::INVOICE->prompt();
            }
        }

        return $additionalPrompt;
    }
}
