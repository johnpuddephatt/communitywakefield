<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberRequestApprovedNotification extends Notification
{
    use Queueable;

    public $team;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($team)
    {
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
        return ($notifiable->notification_emails && in_array('TeamMemberRequestApproved', $notifiable->notification_emails->toArray())) ? ['mail','database'] : ['database'];
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

        return (new MailMessage)
            ->greeting("Your request to join $team->name has been approved")
            ->line("You can now add and manage listings for $team->name")
            ->action('Visit your dashboard', route('dashboard'));
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

        return [
            'title' => "Your request to join $team->name was approved.",
        ];
    }
}
