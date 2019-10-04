<?php

namespace App\Scoping\Scopes;

use Illuminate\Database\Eloquent\Builder;
use App\Scoping\Contracts\Scope;

/**
 *
 */
class CategoryScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereHas('post_category', function ($builder) use ($value) {
            $builder->where('slug', 'like', '%'.$value.'%');
        });
    }
}
