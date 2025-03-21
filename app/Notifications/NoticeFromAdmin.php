<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NoticeFromAdmin extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     protected $notice;
    public function __construct($notice)
    {
        $this->notice =$notice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'notice'=>$this->notice
        ];
    }
}
