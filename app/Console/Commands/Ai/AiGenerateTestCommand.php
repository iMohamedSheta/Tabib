<?php

declare(strict_types=1);

namespace App\Console\Commands\Ai;

use App\Enums\Ai\AiModelEnum;
use App\Enums\Ai\SystemPromptEnum;
use App\Exceptions\FailedToParseResponseException;
use App\Traits\Command\AiFileGenerationApiTrait;
use EchoLabs\Prism\Prism;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AiGenerateTestCommand extends Command
{
    use AiFileGenerationApiTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ai:test {--folder=app\Http\Controllers, app\Http\Requests : list of folders where files are located}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes AI-generated test cases for files in the given folder';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get the folder option and split it into an array of folder paths.
        $foldersInput = $this->option('folder');
        $folderPaths = array_map('trim', explode(',', $foldersInput));

        // Aggregate files from all folders.
        $allFiles = [];

        foreach ($folderPaths as $folder) {
            $absolutePath = base_path($folder);

            if (!File::exists($absolutePath)) {
                $this->error("Folder does not exist: {$absolutePath}");
                continue;
            }

            $files = File::allFiles($absolutePath);

            if (empty($files)) {
                $this->warn("No files found in: {$absolutePath}");
            } else {
                $this->info('Found ' . count($files) . " file(s) in: {$absolutePath}");
                $allFiles = array_merge($allFiles, $files);
            }
        }

        if (empty($allFiles)) {
            $this->error('No files found in any of the specified folders.');

            return;
        }

        // Chunk files into groups of 5 for efficiency.
        $filesChunks = array_chunk($allFiles, 5);
        $allResponses = [];

        foreach ($filesChunks as $filesChunk) {
            try {
                // Randomly select a model.
                $usingModels = [
                    'custom.gemini_1',
                    'gemini',
                ];

                $usingModel = $usingModels[array_rand($usingModels)];

                $filesContents = '';

                foreach ($filesChunk as $file) {
                    $filesContents .= "### File: {$file->getFilename()} ###\n";
                    $filesContents .= File::get($file) . "\n\n";
                }

                $prompt = "These are the files:\n\n" . $filesContents;

                $prism = Prism::text()
                    ->withSystemPrompt(SystemPromptEnum::TEST_GENERATOR->prompt())
                    ->using($usingModel, AiModelEnum::GEMINI_2_0_FLASH_EXP->value)
                    ->usingProviderConfig([
                        'temperature' => 1,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 8192,
                        'responseMimeType' => 'json',
                    ])
                    ->withPrompt($prompt);

                $response = $prism->generate();

                if (empty($response)) {
                    $this->error('AI response is empty.');
                    continue;
                }

                $parsedResponse = $this->generateAiFiles($response);

                $allResponses[] = $parsedResponse;
            } catch (FailedToParseResponseException $e) {
                log_error($e);
                $this->error("AI Parsing Error: {$e->getMessage()}");
                continue;
            } catch (\Exception $e) {
                log_error($e);
                $this->error('Error processing AI response. Check logs for details.');
                continue;
            }
        }

        if ([] !== $allResponses) {
            $this->info('AI generation completed successfully.');
        }
    }
}
