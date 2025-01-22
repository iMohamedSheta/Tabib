<?php

declare(strict_types=1);

namespace App\Console\Commands\Analyze;

use Illuminate\Console\Command;

class AnalyzeCloc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyze:cloc {--exclude=vendor,node_modules,storage : Directories to exclude}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyze the lines of code in the project using cloc';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $excludeDirs = $this->option('exclude');
        $command = "cloc --exclude-dir=$excludeDirs .";

        $this->info('Running cloc analysis...');

        // File to save the report
        $dateTime = now()->format('Y-m-d_H_i_s');
        $reportsDir = base_path('analyze/cloc/');

        $reportPath = $reportsDir . "cloc_report_{$dateTime}.txt";

        $files = glob($reportsDir . '*');

        if (($filesCount = count($files)) > 10) {
            // Sort files by modification time (oldest first)
            usort($files, function ($a, $b): int {
                return filemtime($a) <=> filemtime($b);
            });

            // Keep only the 10 most recent files
            $filesToRemove = array_slice($files, 0, $filesCount - 10);

            // Remove the oldest files
            foreach ($filesToRemove as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }

        // Ensure the directory exists
        if (!file_exists(dirname($reportPath))) {
            mkdir(dirname($reportPath), 0755, true);
        }

        $descriptors = [
            ['pipe', 'r'], // STDIN
            ['pipe', 'w'], // STDOUT
            ['pipe', 'w'], // STDERR
        ];

        $process = proc_open($command, $descriptors, $pipes);

        if (!is_resource($process)) {
            $this->error("Failed to execute cloc. Make sure it's installed and accessible.");

            return Command::FAILURE;
        }

        $output = ''; // To store the command output

        // Read output in real-time
        while (!feof($pipes[1])) {
            $line = fgets($pipes[1]);
            if (false !== $line) {
                $this->line(rtrim($line)); // Display the line in the console
                $output .= $line;         // Append the line to the output
            }
        }

        // Close pipes and process
        fclose($pipes[1]);
        fclose($pipes[2]);

        $returnVar = proc_close($process);

        if (0 === $returnVar) {
            // Add the date and time to the report
            $reportContent = 'cloc Report - Generated on: ' . now()->toDateTimeString() . "\n\n" . $output;

            // Save the report to the file
            file_put_contents($reportPath, $reportContent);

            $this->info("cloc analysis complete. Report saved to: $reportPath");

            return Command::SUCCESS;
        } else {
            $this->error("An error occurred while running cloc. Exit code: $returnVar.");

            return Command::FAILURE;
        }
    }
}
