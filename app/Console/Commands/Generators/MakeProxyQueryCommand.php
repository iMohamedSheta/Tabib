<?php

namespace App\Console\Commands\Generators;

use Illuminate\Console\GeneratorCommand;

class MakeProxyQueryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:proxy:query_builder {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new proxy query builder class';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return resource_path('stubs/proxy_query.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Proxy\QueryBuilders';
    }
}
