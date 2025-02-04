<?php

declare(strict_types=1);

namespace App\Console\Commands\Analyze;

use Illuminate\Console\Command;

class AnalyzePhpStan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyze:stan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze project using static analysis tool phpstan.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Running phpstan analysis...');
        $command = 'composer analyze';

        // File to save the report
        $dateTime = now()->format('Y-m-d_H_i_s');
        $reportsDir = base_path('analyze/stan/');
        $reportPath = "{$reportsDir}stan_report_{$dateTime}.txt";

        // Ensure the reports directory exists
        if (!is_dir($reportsDir)) {
            mkdir($reportsDir, 0755, true);
            $this->info("Created directory: $reportsDir");
        }

        // Get existing report files
        $files = glob("{$reportsDir}*");
        $this->info('Existing reports: ' . count($files));

        // Keep only the 10 most recent reports
        if (count($files) > 10) {
            usort($files, fn ($a, $b): int => filemtime($a) <=> filemtime($b));
            $filesToRemove = array_slice($files, 0, count($files) - 10);

            foreach ($filesToRemove as $file) {
                if (is_file($file) && unlink($file)) {
                    $this->info("Deleted old report: $file");
                }
            }
        }

        // Run phpstan
        exec($command, $output, $returnCode);
        $isSuccess = 0 === $returnCode;
        $message = $isSuccess ? 'PhpStan analysis complete.' : 'PhpStan analysis has some errors.';

        $isSuccess ? $this->info($message) : $this->error($message);

        // Display last error messages if any
        foreach ($output as $key => $line) {
            if (!$isSuccess && $key >= count($output) - 2) {
                $this->error($line);
                continue;
            }
            $this->line($line);
        }
        $reportContent = '# PhpStan Analysis Report - ' . now()->toDateTimeString() . "\n\n" . implode("\n", $output);
        file_put_contents($reportPath, $reportContent);

        $this->info("Report saved to: $reportPath");

        return $isSuccess ? Command::SUCCESS : Command::FAILURE;
    }
}
