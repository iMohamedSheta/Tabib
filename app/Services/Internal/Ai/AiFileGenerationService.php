<?php

declare(strict_types=1);

namespace App\Services\Internal\Ai;

use App\Enums\Ai\AiModelEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Exceptions\FailedToParseResponseException;
use App\Traits\Command\AiFileGenerationApiTrait;
use EchoLabs\Prism\Prism;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class AiFileGenerationService
{
	use AiFileGenerationApiTrait;

	/**
	 * Process the files, chunk them, build the prompt, and generate AI files.
	 *
	 * @param Collection $files
	 * @param string $systemPromptKey  e.g. "TEST_GENERATOR" or another key.
	 * @return array  Array of parsed AI responses.
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
				// Randomly select a model.
				$usingModels = ['custom.gemini_1', 'gemini'];
				$usingModel = $usingModels[array_rand($usingModels)];

				$filesContents = '';
				foreach ($chunk as $file) {
					$filesContents .= "### File: {$file->getFilename()} ###\n";
					$filesContents .= File::get($file) . "\n\n";
				}

				$prompt = "These are the files:\n\n" . $filesContents;

				$prism = Prism::text()
					->withSystemPrompt($systemPrompt) // Use the resolved system prompt.
					->using($usingModel, AiModelEnum::GEMINI_2_0_FLASH_EXP->value)
					->usingProviderConfig([
						'temperature'      => 1,
						'topK'             => 40,
						'topP'             => 0.95,
						'maxOutputTokens'  => 8192,
						'responseMimeType' => 'json',
					])
					->withPrompt($prompt);

				$response = $prism->generate();

				if (empty($response)) {
					continue;
				}

				$parsedResponse = $this->generateAiFiles($response);
				$responses[] = $parsedResponse;
			} catch (FailedToParseResponseException $e) {
				log_error($e);
				continue;
			} catch (\Exception $e) {
				log_error($e);
				continue;
			}
		}

		return $responses;
	}

	/**
	 * Resolve the system prompt based on a key.
	 *
	 * @param string $key
	 * @return string
	 */
	protected function resolveSystemPrompt(string $key): string
	{
		return match (strtolower($key)) {
			'test' || 'test_generator' || 'testing' || 'testing_generator' => SystemPromptEnum::TEST_GENERATOR->prompt(),
			'docs' || 'documentation' || 'document' || 'doc' => SystemPromptEnum::DOCUMENTATION->prompt(),
			'programming' || 'programming' || 'program' => SystemPromptEnum::PROGRAMMING->prompt(),
			default =>  SystemPromptEnum::TEST_GENERATOR->prompt(),
		};
	}
}
