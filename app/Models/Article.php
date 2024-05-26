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
        return $this->hasMany(Word::class, 'article_id', 'id');
    }
}
