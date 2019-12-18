<?php

namespace App;

use App\Traits\Orderable;

class Post extends \Moloquent
{
    use Orderable;

    protected $fillable = ['body'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }
}
