<?php
namespace App\CustomNotifications\Channels;

use ReflectionClass;
use App\CustomNotifications\Notification;

class DatabaseChannels
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function send($notifiable, Notification $notification)
    {
        return $notifiable->routeNotificationFor('database', $notification)->create([
          'id'          => $notification->id,
          'type'        => $this->getType($notification),
          'type_class'  => get_class($notification),
          'data'        => $notification->toArray($notifiable),
          'models'      => json_encode($notification->models()),
          'read_at'     => null
        ]);
    }

    protected function getType(Notification $notification)
    {
        return (new ReflectionClass($notification))->getShortName();
    }
}
