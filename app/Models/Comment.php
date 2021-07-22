<?php

namespace App\Models;

use App\Models\User;
use Laravel\Scout\Searchable;
use App\Models\Traits\UniqueSlug;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\SoftDeletesWithDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletesWithDeleted, Searchable, UniqueSlug;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'parent_id', 'body', 'approved'];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'comments';
    }

    /**
       * Get the owning commentable model.
       */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include approved comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsApproved($builder, $approved = true)
    {
        if ($approved == null) {
            return $builder;
        }
        return $builder->where('approved', $approved);
    }


    /**
     * Scope a query to only include parent.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsParent($builder)
    {
        return $builder->whereNull('parent_id');
    }

    /**
     * [roles description]
     * @return Object permission [description]
     */
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * [roles description]
     * @return Object permission [description]
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * [roles description]
     * @return Object permission [description]
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id')->latest();
    }
}
