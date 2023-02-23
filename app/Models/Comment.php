<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

  public function articles(): BelongsTo{

    return $this->belongsTo(Article::class);

  }
  protected $fillable =[
    'user_id',
    'article_id',
    'body',
  ];

}
