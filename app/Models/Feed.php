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
        'homepage',
        'type',
        'icon_url'
    ];

    protected $appends = [
        'status'
    ];

    public function statuses()
    {
        return $this->hasMany(FeedStatus::class);
    }

    public function lastStatus()
    {
        return $this->hasOne(FeedStatus::class)->orderBy('id', 'desc');
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

    public function getStatusAttribute(): bool
    {
        return $this->lastStatus->online ?? true;
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
