<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Traits\IsLive;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Scoping\Scopes\TagScope;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use CanBeScoped,LatestOrder,IsLive,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'body', 'slug', 'image', 'summary', 'live'
    ];

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * Get all of the tags for the post.
    */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scopes()
    {
        return [
          'tag'       => new TagScope(),
          'category'  => new CategoryScope()
        ];
    }
}
