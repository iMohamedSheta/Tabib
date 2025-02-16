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
    public ?PromptModel $promptModel = null;
    public array $topics = [];

    public array $topicsChecked = [];

    public function mount(): void
    {
        $this->messages[] = [
            'type' => 'ai',
            'message' => PromptMessageEnum::WELCOME->prompt(),
        ];

        $this->promptModels = PromptModel::list();

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

            $newPrompt = [$this->promptModel->id => $this->promptModel->name];

            $this->promptModels = $newPrompt + $this->promptModels;
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
                ->withSystemPrompt(SystemPromptEnum::DEFAULT->prompt())
                ->withSystemPrompt("here is the conversation history: \n" . $conversationHistory)
                ->withSystemPrompt('these are the user information :' . SystemPromptEnum::AUTH->prompt())
                ->withSystemPrompt('these are the additional prompt data that may be helpful to the AI: ' . $this->getAdditionalPromptTopics())
                ->withSystemPrompt('these are my semantic search results for the conversation :' . PromptTopicEnum::getSemanticTopic($conversationHistory . "\n\n" . $prompt))
                ->using('custom.gemini_1', AiModelEnum::GEMINI_EXP_1206->value)
                ->usingProviderConfig([
                    'temperature' => 0.3,
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

    public function setPromptModel(?int $promptModel = null): void
    {
        if (null !== $promptModel) {
            $promptModel = PromptModel::find($promptModel);
        }

        $this->messages = [];

        $this->promptModel = $promptModel;

        $this->dispatch('prompt-model-changed');
    }

    public function render()
    {
        $this->messages = [];
        $this->messages[] = [
            'type' => 'ai',
            'message' => PromptMessageEnum::WELCOME->prompt(),
        ];

        if ($this->promptModel instanceof PromptModel) {
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
