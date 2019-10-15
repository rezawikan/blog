<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
trait HasChildren
{
  
  /**
   * Scope a query to only include approved comment.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $builder
   * @return \Illuminate\Database\Eloquent\Builder
   */
    public function scopeParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    /**
     * Scope a query to only include approved comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasParent($builder)
    {
      $parent = $this->parent()->count();

      return $parent > 0 ? true : false;
    }
}
