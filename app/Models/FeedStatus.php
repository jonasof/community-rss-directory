<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedStatus extends Model
{
    public $fillable = [
        'online'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
