<?php

namespace App\Notifications;

use App\Models\Discussion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MarkedAsBestReply extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your reply on: ' . $this->discussion->title)
            ->line('Your reply was marked as best reply.')
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
            'message' => 'Your reply was marked as the best reply!',
        ];
    }
}
