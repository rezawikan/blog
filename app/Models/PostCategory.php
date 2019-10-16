<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasChildren;
use App\Models\Traits\IsOrderable;
use Laravel\Scout\Searchable;
use App\Models\Traits\UniqueSlug;
use App\Models\Traits\SoftDeletesWithDeleted;

class PostCategory extends Model
{
  
    use HasChildren, IsOrderable, Searchable, UniqueSlug, SoftDeletesWithDeleted;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',  'order', 'parent_id'
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'post_categories';
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id', 'id');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }


    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Block comment
     *
     * @param type
     * @return void
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id', 'id');
    }
}
