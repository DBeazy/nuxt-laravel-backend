<?php

namespace App;

use App\Traits\Orderable;

class Topic extends \Moloquent
{
    use Orderable;

    protected $fillable = ['title'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }
}
