<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
    protected $fillable = ['name'];

    /**
     * [roles description]
     * @return Object permission [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }
}
