<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->index('article_id', 'article_id_word_inx');
            $table->index('word', 'word_word_inx');
            $table->index('count', 'count_word_inx');
        });
    }

    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropIndex(['article_id_word_inx']);
            $table->dropIndex(['word_word_inx']);
            $table->dropIndex(['count_word_inx']);
        });
    }
};
