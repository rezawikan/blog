<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait LatestOrder
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function scopeLatestOrder(Builder $builder)
    {
        return $builder->orderBy('created_at','desc');
    }
}
