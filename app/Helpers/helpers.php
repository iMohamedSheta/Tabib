<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use IMohamedSheta\Todo\Attributes\TODO;

if (!function_exists('speedTest')) {
    /**
     * Measure the execution time of a given code block executed multiple times.
     *
     * @param callable $callback the code block to measure
     * @param int      $repeats  the number of times to execute the callback
     *
     * @return array the execution time in milliseconds and the result of the last execution
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
        $averageExecutionTime = number_format($totalExecutionTime / $repeats, 2) . ' ms';
        $totalExecutionTimeInSeconds = number_format($totalExecutionTime / 1000, 2) . ' seconds';

        // Return both the result of the last execution and the average execution time
        return [
            'result' => $lastResult,
            'average_execution_time' => $averageExecutionTime,
            'total_execution_time' => $totalExecutionTimeInSeconds,
        ];
    }
}

if (!function_exists('log_error')) {
    function log_error(Exception $exception): void
    {
        Log::error('Exception Occurred: ', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
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

        if (str_ends_with($filename, '.js')) {
            return asset('assets/js/' . $filename . '?' . cache()->get('js_version'));
        }

        return asset(sprintf('assets/js/%s.js?', $filename) . cache()->get('js_version'));
    }
}

if (!function_exists('css')) {
    function css(string $filename)
    {
        $version = cache()->get('css_version') ?? null;

        if (is_null($version)) {
            $version = cache()->forever('css_version', config('app.versions.app') . config('app.versions.css'));
        }

        if (str_ends_with($filename, '.css')) {
            return asset('assets/css/' . $filename . '?' . $version);
        }

        return asset(sprintf('assets/css/%s.css?', $filename) . $version);
    }
}

if (!function_exists('obj')) {
    function obj(array $objectData): object
    {
        return json_decode(json_encode($objectData));
    }
}
if (!function_exists('array_only')) {
    /**
     * HELPER FUNCTION
     * Get a subset of the items from the given array based on the specified keys.
     *
     * @param array $array the array to extract items from
     * @param array $keys  the keys to extract from the array
     *
     * @return array an array containing only the items with the specified keys
     */
    #[TODO]
    function array_only(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }
}

if (!function_exists('log_dev')) {
    function log_dev($e): void
    {
        Log::channel('dev')->error($e);
    }
}
