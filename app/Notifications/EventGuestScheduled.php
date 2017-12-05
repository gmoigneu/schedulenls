<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Event;

class EventGuestScheduled extends Notification
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
                    ->subject('Your event is waiting for your validation')
                    ->greeting('You have requested a meeting.')
                    ->line('With: ' . $this->event->user->email)
                    ->line('Type: ' . $this->event->eventType->name . ' (' . \Carbon\CarbonInterval::minutes($this->event->eventType->duration) . ')')
                    ->line('Date: ' . \Carbon\Carbon::parse($this->event->start)->toDayDateTimeString())
                    ->line('Summary: ' . $this->event->summary)
                    ->line('')
                    ->line('Please click the following button to confirm the meeting.')
                    ->action('Validate this event!' , route('confirm', ['user' => $this->event->user, 'event' => $this->event, 'token' => $this->event->token]));
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
