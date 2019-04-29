<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait IsLive
{
      /**
       * Scope a query to only include popular users.
       *
       * @param \Illuminate\Database\Eloquent\Builder $query
       * @return \Illuminate\Database\Eloquent\Builder
       */
    public function scopeIsLive(Builder $builder)
    {
        return $builder->where('live',true);
    }
}
