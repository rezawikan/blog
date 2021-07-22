<?php

namespace App\Models;

use App\Models\Post;
use Laravel\Scout\Searchable;
use App\Models\Traits\UniqueSlug;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\SoftDeletesWithDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, SoftDeletesWithDeleted, UniqueSlug, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug'
    ];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'tags';
    }
}
