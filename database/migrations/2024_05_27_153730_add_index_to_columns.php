<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            DB::statement("CREATE FULLTEXT INDEX idx_words_word ON words(word)");
        });
    }

    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropIndex(['idx_words_word']);
        });
    }
};
