<?php

use App\Console\Commands\Analyze\AnalyzeCloc;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command;

use function Pest\Laravel\artisan;


uses(
    Tests\TestCase::class,
)->in('Feature');


it('can execute the analyze:cloc command successfully', function () {
    File::shouldReceive('exists')->once()->andReturn(false);
    File::shouldReceive('makeDirectory')->once()->andReturn(true);

    $dateTime = now()->format('Y-m-d_H_i_s');
    $reportsDir = base_path('analyze/cloc/');
    $reportPath = $reportsDir . "cloc_report_{$dateTime}.txt";

    $command = "cloc --exclude-dir=vendor,node_modules,storage .";
    $reportContent = 'cloc Report - Generated on: ' . now()->toDateTimeString() . "\n\n";

    $process = Mockery::mock();
    $process->shouldReceive('close')->once()->andReturn(0);

    $mock = Mockery::mock();
    $mock->shouldReceive('executeShellCommand')
        ->once()
        ->with($command)
        ->andReturn($reportContent);

    File::shouldReceive('put')->once()->with($reportPath, $reportContent)->andReturn(true);

    $this->app->bind(AnalyzeCloc::class, function () use ($mock) {
        return $mock;
    });

    artisan('analyze:cloc')
        ->assertExitCode(Command::SUCCESS);

});

it('handles cloc execution failure', function () {
    $command = "cloc --exclude-dir=vendor,node_modules,storage .";

    $process = Mockery::mock();
    $process->shouldReceive('close')->once()->andReturn(1);

    $mock = Mockery::mock();
    $mock->shouldReceive('executeShellCommand')
        ->once()
        ->with($command)
        ->andReturn('Error message');

    $this->app->bind(AnalyzeCloc::class, function () use ($mock) {
        return $mock;
    });

    artisan('analyze:cloc')
        ->assertExitCode(Command::FAILURE);
});


