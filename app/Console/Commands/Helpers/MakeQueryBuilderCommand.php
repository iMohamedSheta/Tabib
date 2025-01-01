<?php

namespace App\Console\Commands\Helpers;

use Illuminate\Console\GeneratorCommand;

class MakeQueryBuilderCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:query_builder {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new query builder class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('stubs/query_builder.stub');
    }


    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\QueryBuilders';
    }
}
