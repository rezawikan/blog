<?php

namespace App\Models;

use App\Models\Post;
use Laravel\Passport\HasApiTokens;
use App\Model\Traits\RolePermission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\API\Auth\ResetPasswordNotification;
use App\App\Notifications\Models\DatabaseNotification;
use App\Models\Traits\SoftDeletesWithDeleted;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, RolePermission, SoftDeletesWithDeleted, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'users';
    }

    /**
     * [posts description]
     * @return [type] [description]
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    /**
     * [posts description]
     * @return [type] [description]
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope a query to only include approved comment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasComment($builder, $id)
    {
      $comment = $this->whereHas('comments', function ($builder) use ($id) {
        $builder->where('id', $id);
      })->count();

      return $comment > 0 ? true : false;
    }

    /**
     * [posts description]
     * @return [type] [description]
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at','desc');
    }

    /**
   * Send the password reset notification.
   *
   * @param  string  $token
   * @return void
   */
    public function sendPasswordResetNotification($token)
    {
        $when = now()->addSeconds(5);

        $this->notify((new ResetPasswordNotification($token))->delay($when));
    }

    /**
    * Route notifications for the mail channel.
    *
    * @param  \Illuminate\Notifications\Notification  $notification
    * @return string
    */
   public function routeNotificationForMail($notification)
   {
       return $this->email;
   }
}
