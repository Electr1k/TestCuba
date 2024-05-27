<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_word', 'word_id', 'article_id');
    }
}
