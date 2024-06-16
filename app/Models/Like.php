<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        "post_id",
        "user_id",

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
