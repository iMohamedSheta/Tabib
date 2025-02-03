<?php

declare(strict_types=1);

namespace App\Services\Internal\Ai;

use App\Enums\Ai\AiModelEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Exceptions\FailedToParseResponseException;
use App\Traits\Command\AiFileGenerationApiTrait;
use EchoLabs\Prism\Enums\FinishReason;
use EchoLabs\Prism\Prism;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class AiFileGenerationService
{
    use AiFileGenerationApiTrait;

    /**
     * Process the files, chunk them, build the prompt, and generate AI files.
     *
     * @param string $systemPromptKey e.g. "TEST_GENERATOR" or another key.
     *
     * @return array array of parsed AI responses
     */
    public function processFiles(Collection $files, string $systemPromptKey, int $chunkSize = 5): array
    {
        $responses = [];
        // Convert files collection to chunks of 5.
        $fileChunks = $files->chunk($chunkSize);

        // Determine the system prompt string based on the provided key.
        $systemPrompt = $this->resolveSystemPrompt($systemPromptKey);

        foreach ($fileChunks as $chunk) {
            try {
                // randomly select a model from the list of models.
                $usingModels = [
                    'custom.gemini_1' => AiModelEnum::GEMINI_2_0_FLASH_EXP->value,
                    'gemini' => AiModelEnum::GEMINI_2_0_FLASH_EXP->value,
                    // 'ollama' => AiModelEnum::DEEPSEEK_R1_7B->value
                ];
                $modelKey = array_rand($usingModels);

                $model = $usingModels[$modelKey];

                $filesContents = '';
                foreach ($chunk as $file) {
                    $filesContents .= "### File: {$file->getFilename()} ###\n";
                    $filesContents .= File::get($file) . "\n\n";
                }

                $prompt = "These are the files:\n\n" . $filesContents;

                $prism = Prism::text()
                    ->withSystemPrompt($systemPrompt) // Use the resolved system prompt.
                    ->using($modelKey, $model)
                    ->usingProviderConfig([
                        'temperature' => 1,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 8192,
                        'responseMimeType' => 'json',
                    ])
                    ->withPrompt($prompt);

                $response = $prism->generate();

                if (FinishReason::Stop !== $response->finishReason) {
                    continue;
                }

                $parsedResponse = $this->generateAiFiles($response);
                $responses[] = $parsedResponse;
            } catch (FailedToParseResponseException|\Exception $e) {
                log_error($e);
                continue;
            }
        }

        return $responses;
    }

    /**
     * Resolve the system prompt based on a key.
     */
    protected function resolveSystemPrompt(string $key): string
    {
        return match (strtolower($key)) {
            'test', 'test_generator', 'testing', 'testing_generator' => SystemPromptEnum::TEST_GENERATOR->prompt(),
            'docs', 'documentation', 'document', 'doc' => SystemPromptEnum::DOCUMENTATION->prompt(),
            'programming', 'program' => SystemPromptEnum::PROGRAMMING->prompt(),
            default => SystemPromptEnum::TEST_GENERATOR->prompt(),
        };
    }
}
