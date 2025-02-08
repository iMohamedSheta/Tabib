<?php

use App\Macros\CacheMacro;
use App\Macros\QueryBuilderMacro;
use App\Providers\MacroServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


beforeEach(function () {
    $this->app->register(MacroServiceProvider::class);
});

it('registers QueryBuilderMacro and CacheMacro during boot', function () {
    expect(DB::getQueryGrammar())->toHaveMethods([
        'macroPaginate',
    ]);

    expect(Cache::class)->toHaveMethods([
        'rememberForeverWithTtl',
    ]);
});


it('QueryBuilderMacro::boot registers the macroPaginate macro', function () {
    QueryBuilderMacro::boot();
    expect(DB::getQueryGrammar())->toHaveMethods(['macroPaginate']);
});


it('CacheMacro::boot registers the rememberForeverWithTtl macro', function () {
    CacheMacro::boot();
    expect(Cache::class)->toHaveMethods(['rememberForeverWithTtl']);
});

