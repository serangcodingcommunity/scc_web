<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
