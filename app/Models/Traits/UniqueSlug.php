<?php

namespace App\Models\Traits;

trait UniqueSlug
{
    /**
     * Set the post's slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
          $slug = $this->incrementSlug($slug);
        }
        
        $this->attributes['slug'] = $slug;
    }

    /**
     * [user description]
     * @return [type] [description]
     */
    protected function incrementSlug($slug) {
      $original = $slug;
      $count = 2;
      while (static::whereSlug($slug)->exists()) {
          $slug = "{$original}-" . $count++;
      }

      return $slug;
    }
}
