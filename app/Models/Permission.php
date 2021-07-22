<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use Laravel\Scout\Searchable;
use App\Models\Traits\SoftDeletesWithDeleted;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory, Searchable;

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
        return 'permissions';
    }

    /**
     * [roles description]
     * @return Object permission [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }
}
