<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->article_id,
            'title' => $this->title,
            'url' => $this->url,
            'size' => $this->size,
            'plain_text' => $this->plain_text,
            'count' => $this->count,
            'word' => $this->word
        ];
    }
}
