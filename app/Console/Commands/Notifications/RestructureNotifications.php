<?php

namespace App\Console\Commands\Notifications;

use ReflectionClass;
use Illuminate\Console\Command;
use  App\App\Notifications\Models\DatabaseNotification;

class RestructureNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:restructure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restructure Notifications';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = DatabaseNotification::query();

        $bar = $this->output->createProgressBar($notifications->count());

        $notifications->chunk(100, function($notifications) use ($bar){
          $notifications->each(function($notification) use ($bar){
            $recrated = $this->recreateNotification(
              $notification,
              $this->resolveModels($notification->models)
            );

            $notification->update([
              'data' => $recrated->toArray($notification->notifable)
            ]);

            $bar->advance();
          });
        });

        $bar->finish();
    }

    protected function resolveModels(array $models)
    {
      return array_map(function ($model){
        if (method_exists($model->class, 'trashed')) {
            return $model->class::withTrashed()->find($model->id);
        }
        return $model->class::find($model->id);
      }, $models);
    }

    protected function recreateNotification(DatabaseNotification $notification, $args)
    {
      return (new ReflectionClass($notification->type_class))->newInstanceArgs($args);
    }
}
