<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $fillable = ['user_id', 'parent_id', 'body', 'approved'];


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
      public function children()
      {
          return $this->hasMany(Comment::class, 'parent_id')->latest();
      }

}
