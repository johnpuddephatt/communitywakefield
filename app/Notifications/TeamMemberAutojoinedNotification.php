<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberAutojoinedNotification extends Notification
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
        return ($notifiable->notification_emails && in_array('TeamMemberAutojoined', $notifiable->notification_emails->toArray())) ? ['mail','database'] : ['database'];
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
            ->greeting("$team->name has a new member")
            ->line("$user->name ($user->email) has just joined $team->name and is now able to manage the organisation’s listings.")
            ->line("This has happened automatically because you have autojoin enabled and $user->name has a matching email address.")
            ->line("If you do not recognise $user->name as being a member of your organisation, visit the link below to manage your members.")
            ->action('Manage team settings', route('teams.show', $team->id));
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
            'title' => "$user->name ($user->email) has automatically joined $team->name.",
            'action' => [
                'text' => "Manage team settings",
                'url' => route('teams.show', $team->id)
            ]
        ];
    }
}
