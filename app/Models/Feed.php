<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;

use Conner\Tagging\Taggable;

class Feed extends Model implements Auditable
{
    use Taggable;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'url',
        'title',
        'description',
        'tags',
        'status',
        'homepage',
        'type'
    ];

    public function feedStatuses()
    {
        return $this->hasMany(FeedStatus::class);
    }

    public function setTagsAttribute($tags)
    {
        if (empty($tags)) {
            $tags = [];
        }

        $this->saved(function () use ($tags) {
            $this->retag($tags);
        });
    }

    public static function getSearchQuery($tag)
    {
        $query = self::query()->with(['tagged']);

        if ($tag) {
            $query->withAnyTag($tag);
        }

        return $query;
    }
}
