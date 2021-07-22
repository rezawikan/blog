<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Comment;
use Laravel\Scout\Searchable;
use App\Models\Traits\IsLive;
use App\Models\Traits\CanBeScoped;
use App\Models\Traits\LatestOrder;
use App\Scoping\Scopes\TagScope;
use App\Scoping\Scopes\CategoryScope;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\SoftDeletesWithDeleted;
use App\Models\Traits\UniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, CanBeScoped, LatestOrder, IsLive, SoftDeletesWithDeleted, UniqueSlug, Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'post_category_id', 'title', 'body', 'slug', 'image', 'summary', 'live'
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'posts';
    }

    /**
     * Scope a query to only include approved comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasUser($builder, $id)
    {
        $user = $this->whereHas('user', function ($builder) use ($id) {
            $builder->where('id', $id);
        })->count();

        return $user > 0 ? true : false;
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
