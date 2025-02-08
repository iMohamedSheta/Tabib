<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ensure the pg-vector extension is enabled
        if ('http://localhost' == config('app.url')) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS vector;');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ('http://localhost' == config('app.url')) {
            DB::statement('DROP EXTENSION vector');
        }
    }
};
