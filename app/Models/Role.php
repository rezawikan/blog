<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Role extends Model
{

  use Searchable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = ['name'];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'roles';
    }

    /**
     * [permissions description]
     * @return Object permission [description]
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }
}
