<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Comment;
use App\Models\Traits\IsLive;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Scoping\Scopes\TagScope;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\SoftDeletesWithDeleted;

class Post extends Model
{
    use CanBeScoped, LatestOrder, IsLive, SoftDeletesWithDeleted;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_category_id', 'title', 'body', 'slug', 'image', 'summary', 'live'
    ];

    /**
     * Set the post's slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
          $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    protected function incrementSlug($slug) {
      $original = $slug;
      $count = 2;
      while (static::whereSlug($slug)->exists()) {
          $slug = "{$original}-" . $count++;
      }

      return $slug;
  }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }

      /**
      * Get all of the post's comments.
      */
     public function comments()
     {
         return $this->morphMany(Comment::class, 'commentable');
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
          'none'      => 'Testing Unit',
          'tag'       => new TagScope(),
          'category'  => new CategoryScope(),

        ];
    }
}
