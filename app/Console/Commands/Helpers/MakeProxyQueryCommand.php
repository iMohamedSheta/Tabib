<?php

namespace App\Console\Commands\Helpers;

use Illuminate\Console\GeneratorCommand;

class MakeProxyQueryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:proxy:query {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new proxy query class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return resource_path('stubs/proxy_query.stub');
    }


    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Proxy\Query';
    }

}
