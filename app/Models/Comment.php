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
      protected $fillable = ['user_id', 'parent_id', 'body'];


        /**
       * Get the owning commentable model.
       */
      public function commentable()
      {
          return $this->morphTo();
      }


      /**
       * [roles description]
       * @return Object permission [description]
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
