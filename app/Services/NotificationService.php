<?php 

namespace App\Services;

use App\Notifications\PostNotification;

class NotificationService
{
    public function sendNotificationByEmail($user, $post)
    {
        return $user->notify(new PostNotification($post));
    }
}