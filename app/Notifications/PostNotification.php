<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('New Post has been created.')
                    ->action('View Post', url('/api/posts/'.$this->post['id']))
                    ->line('Title: '.$this->post['title'])
                    ->line('Description: '.$this->post['description']);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
