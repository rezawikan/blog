<?php

namespace App\Notifications\Comments;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
// use Illuminate\Notifications\Notification;
// use Illuminate\Notifications\Channels\DatabaseChannel;
use App\App\Notifications\Channels\DatabaseChannel;
use App\App\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentCreated extends Notification
{
    use Queueable;

    public $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // dd($this->models());
        // return ['database'];
        return [
          DatabaseChannel::class, 'mail'
        ];

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'comment' => [
              'id'   => $this->comment->id,
              'body' => $this->comment->body
            ]
        ];
    }
}
