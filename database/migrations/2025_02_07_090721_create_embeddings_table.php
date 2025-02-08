<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('embeddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->morphs('embeddable');
            $table->string('key');
            $table->text('content');
            $table->vector('embedding', 768)->nullable();
            $table->vector('embedding_1536', 1536)->nullable();
            $table->timestamps();
        });

        // Create an index on the embedding column for fast similarity search by using the IVF-FLAT index
        DB::statement('CREATE INDEX ON embeddings USING ivfflat (embedding vector_cosine_ops) WITH (lists = 100);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embeddings');
    }
};
