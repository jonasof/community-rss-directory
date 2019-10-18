<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use OwenIt\Auditing\Contracts\Auditable;
use Conner\Tagging\Taggable;

class Feed extends Model implements Auditable
{
    use EloquentJoin;
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
        'status',
        'tags'
    ];

    public function statuses()
    {
        return $this->hasMany(FeedStatus::class);
    }

    public function lastStatus()
    {
        return $this->hasOne(FeedStatus::class)->orderBy('id', 'desc');
    }

    public function getTagsAttribute()
    {
        return $this->tagged->map(function($item){
            return $item->tag->slug ?? '';
        })->filter();
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

    public function scopeWithTags($query, $tag = null)
    {
        return $query->when($tag, function($query) use ($tag) {
            return $query->withAnyTag($tag);
        });
    }
}
