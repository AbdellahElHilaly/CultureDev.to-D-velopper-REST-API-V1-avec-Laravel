<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'category' => $this->category->name,
            'user' => $this->user->name,
        ];

        if ($this->tags->isNotEmpty()) {
            $data['tags'] = $this->tags->pluck('name')->toArray();
        }

        return $data;
    }
}
