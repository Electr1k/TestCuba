<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $guarded = false;

    public function words()
    {
        return $this->belongsToMany(Word::class, 'article_word', 'article_id', 'word_id');
    }
}
