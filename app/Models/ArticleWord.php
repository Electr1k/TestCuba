<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleWord extends Model
{
    use HasFactory;
    protected $table = 'article_word';
    public $timestamps = false;
    protected $guarded = false;

    public function articles()
    {
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }


    public function words()
    {
        return $this->belongsTo(Word::class, 'word_id', 'id');
    }
}
