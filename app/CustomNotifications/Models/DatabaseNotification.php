<?php

namespace App\CustomNotifications\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class DatabaseNotification extends BaseDatabaseNotification
{
    public function getModelsAttribute($value)
    {
        return (array) json_decode($value);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
