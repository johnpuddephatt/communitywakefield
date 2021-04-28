<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberRequestNotification extends Notification
{
    use Queueable;

    public $team;
    public $user;
    public $teamRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($team, $user, $teamRequest)
    {
        $this->user = $user;
        $this->team = $team;
        $this->teamRequest = $teamRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
     public function via($notifiable)
     {
         return ($notifiable->notification_emails && in_array('TeamMemberRequestReceived', $notifiable->notification_emails->toArray())) ? ['mail','database'] : ['database'];
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
         $teamRequest = $this->teamRequest;

         return (new MailMessage)
             ->greeting("$user->name has requested to join $team->name")
             ->line("$user->name ($user->email) has just requested to join $team->name.")
             ->line("If you recognose $user->name and want them to join your team, you can approve this request below.")
             ->action('Approve this request', route('teams.approveRequest', ['team' => $team->id, 'teamRequest' => $teamRequest->id]));
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
         $teamRequest = $this->teamRequest;

         return [
             'title' => "$user->name ($user->email) has requested to join $team->name.",
             'action' => [
                 'text' => "Approve this request",
                 'url' => route('teams.approveRequest', ['team' => $team->id, 'teamRequest' => $teamRequest->id])
             ]
         ];
     }
}
