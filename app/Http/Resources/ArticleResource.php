<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'category' => new CategoryResource($this->category),
            'comments' => CommentResource::collection($this->comments),
            'tags' => $this->tags->pluck('name'),
        ];
    }




    
    // public function toArray($request)
    // {

    //     $data = [
    //         'id' => $this->id,
    //         'user' => $this->user->name,
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'content' => $this->content,
    //         'category' => $this->category,
    //         'comment' => $this->comments,
    //     ];

    //     if ($this->tags->isNotEmpty()) {
    //         $data['tags'] = $this->tags->pluck('name')->toArray();
    //     }

    //     return $data;
    // }
}

/*

{
    "status": 201,
    "message": "Article created successfully",
    "data": {
        "id": 13,
        "user": "autheur",
        "title": "article title",
        "description": "article description",
        "content": "article content",
        "category": {
            "name": "Category name",
        },
        "comments": [
            {
                "user" : "user name",
                "comment" : "comment body",
            }
            {
                "user" : "user name",
                "comment" : "comment body",
            }
        ],

        "tags": [
            "adfrk",
            "cdcz"
        ]
    }
}


*/
