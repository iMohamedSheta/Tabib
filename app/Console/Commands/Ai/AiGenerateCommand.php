<?php

declare(strict_types=1);

namespace App\Console\Commands\Ai;

use App\Services\Internal\Ai\AiFileGenerationService;
use App\Services\Internal\Collector\FileCollectorService;
use Illuminate\Console\Command;

class AiGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * The --folders option accepts a comma-separated list of folders.
     * The --files option accepts a comma-separated list of specific files to process.
     * The --system-prompt option accepts a system prompt key. For example: TEST_GENERATOR.
     *
     * @var string
     */
    protected $signature = 'ai:generate 
        {--folders= : List of folders where files are located}
		{--files= : List of files to process}
        {--system-prompt=TEST_GENERATOR : The key for the system prompt to use}
		{--chunk-size=5 : The number of files to process at once}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes AI-generated test cases for files in the given folders or for specific files.
	Example usage:
		php artisan ai:generate --folders="app\Console\Commands\Ai,app\Traits\Command" --system-prompt=test --chunk-size=2
		php artisan ai:generate --files="app/Console/Commands/Ai/AiGenerateTestCommand.php,app/Traits/Command/AiGenerateFilesApi.php"';

    protected FileCollectorService $fileCollector;
    protected AiFileGenerationService $aiFileGenerationService;

    public function __construct(FileCollectorService $fileCollector, AiFileGenerationService $aiFileGenerationService)
    {
        parent::__construct();
        $this->fileCollector = $fileCollector;
        $this->aiFileGenerationService = $aiFileGenerationService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $foldersInput = $this->option('folders');
        $filesInput = $this->option('files');

        $files = $this->fileCollector->collectFiles($foldersInput, $filesInput);

        if ($files->isEmpty()) {
            $this->error('No files found in any of the specified folders.');

            return;
        }

        $this->info('Total files found: ' . $files->count());

        // Retrieve the system prompt key from the option.
        $systemPromptKey = $this->option('system-prompt');

        $chunkSize = (int) $this->option('chunk-size');

        // Let the service determine the actual prompt string.
        $responses = $this->aiFileGenerationService->processFiles($files, $systemPromptKey, $chunkSize);

        if (!empty($responses)) {
            $this->info('AI generation completed successfully.');
        } else {
            $this->error('AI generation failed for all file chunks.');
        }
    }
}
