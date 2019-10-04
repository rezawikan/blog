<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class TagScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        if ($value == null) {
            return $builder;
        }
        return $builder->whereHas('tags', function ($builder) use ($value) {
            $builder->whereIn('slug', $value);
        });
    }
}
