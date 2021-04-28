<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamCreatedNotification extends Notification
{
    use Queueable;

    public $team;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($team, $user)
    {
        $this->user = $user;
        $this->team = $team;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $team = $this->team;
        $user = $this->user;

        return (new MailMessage)
            ->greeting("New organisation created")
            ->line("A new organisation – $team->name – has been created.")
            ->line("This organisation was created by $user->name ($user->email).")
            ->line("If you are unsure whether this account is genuine, consider disabling it while you investigate further.")
            ->action('Edit this team', route('filament.resources.teams.edit', $team->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $team = $this->team;
        $user = $this->user;

        return [
            'title' => "$team->name has been created by $user->name ($user->email)",
            'action' => [
                'text' => "Edit this team",
                'url' => route('filament.resources.teams.edit', $team->id)
            ]
        ];
    }
}
