<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplyAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public Discussion $discussion;

    /**
     * Create a new notification instance.
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New reply on: ' . $this->discussion->title)
            ->line('Someone replied to your discussion.')
            ->action('View Discussion', route('discussion.show', $this->discussion->slug))
            ->line('Thank you for using our forum!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'discussion' => $this->discussion,
            'message' => 'A new reply was added to your discussion.',
        ];
    }
}
