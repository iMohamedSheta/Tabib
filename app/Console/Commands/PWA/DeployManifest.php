<?php

namespace App\Console\Commands\PWA;

use App\Services\Internal\PWA\ManifestService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DeployManifest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pwa:manifest-deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the manifest.json into a json file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $output = (new ManifestService())->generate();
        File::put(public_path('manifest.json'), json_encode($output, JSON_PRETTY_PRINT));

        $this->info('manifest.json file has been created.');
    }
}
