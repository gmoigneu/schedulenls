<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Event;

class EventScheduled extends Notification
{
    use Queueable;

    protected $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->subject('A new event has been scheduled.')
                    ->greeting('A new event has been scheduled.')
                    ->line($this->event->name . ' (' . $this->event->email . ') from ' . $this->event->organization . ' requested a new meeting.')
                    ->line('Type: ' . $this->event->eventType->name . ' (' . \Carbon\CarbonInterval::minutes($this->event->eventType->duration) . ')')
                    ->line('Date: ' . \Carbon\Carbon::parse($this->event->start)->toDayDateTimeString())
                    ->action('Go to your dashboard', route('dashboard'));
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
            //
        ];
    }
}
