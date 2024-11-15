
<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('speedTest')) {
    /**
     * Measure the execution time of a given code block executed multiple times.
     *
     * @param callable $callback The code block to measure.
     * @param int $repeats The number of times to execute the callback.
     * @return array The execution time in milliseconds and the result of the last execution.
     */
    function speedTest(callable $callback, int $repeats = 1): array
    {
        $lastResult = null;
        $totalExecutionTime = 0;
        $lastRepeat = $repeats - 1;

        for ($i = 0; $i < $repeats; $i++) {
            $startTime = microtime(true);

            // Execute the callback and capture the result
            if ($lastRepeat == $i) {
                $lastResult = call_user_func($callback);
            } else {
                call_user_func($callback);
            }

            // Calculate the execution time
            $executionTime = (microtime(true) - $startTime) * 1000;
            $totalExecutionTime += $executionTime;
        }

        // Average execution time
        $averageExecutionTime = number_format($totalExecutionTime / $repeats, 2) . " ms";
        $totalExecutionTimeInSeconds = number_format($totalExecutionTime / 1000, 2) . " seconds";
        // Return both the result of the last execution and the average execution time
        return [
            'result' => $lastResult,
            'average_execution_time' => $averageExecutionTime,
            'total_execution_time' => $totalExecutionTimeInSeconds
        ];
    }
}

if (!function_exists('log_error')) {
    function log_error(\Exception $e)
    {
        Log::error('Exception Occurred: ', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}

if (!function_exists('getAppName')) {
    function getAppName()
    {
        return config('app.name');
    }
}

if (!function_exists('js')) {
    function js(string $filename)
    {
        $version = cache()->get('js_version') ?? null;

        if (is_null($version)) {
            $version = cache()->forever('js_version', config('app.versions.app') . config('app.versions.js'));
        }

        if (str_ends_with($filename, '.js')){
            return asset('assets/js/' . $filename . '?' . cache()->get('js_version'));
        }

        return asset("assets/js/{$filename}.js?". cache()->get('js_version'));
    }
}

if (!function_exists('css')) {
    function css(string $filename)
    {
        $version = cache()->get('css_version') ?? null;

        if (is_null($version)) {
            $version = cache()->forever('css_version', config('app.versions.app') . config('app.versions.css'));
        }

        if (str_ends_with($filename, '.css')){
            return asset('assets/css/' . $filename . '?' . $version);
        }

        return asset("assets/css/{$filename}.css?". $version);
    }
}

if (!function_exists('obj')) {
    function obj(array $objectData)
    {
        return json_decode(json_encode($objectData));
    }
}
