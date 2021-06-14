<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class EnquiryNotification extends Notification
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $enquirable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enquiry, $enquirable)
    {
        $this->enquiry = $enquiry;
        $this->enquirable = $enquirable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // If we’re emailing the creator of the entry AND they receive EnquiryCreated notifications
        // Or, we're emailing a team member who receives TeamEnquiryCreated notifications
        return ($notifiable->id == $this->enquirable->creator->id &&
            $notifiable->receives("EnquiryCreated")) ||
            $notifiable->receives("TeamEnquiryCreated")
            ? ["mail", "database"]
            : ["database"];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $enquiry = $this->enquiry;
        $enquirable = $this->enquirable;

        return (new MailMessage())
            ->replyTo($enquiry->email, $enquiry->name)
            ->greeting("Enquiry received about $enquirable->title")
            ->line(new HtmlString("<br><hr>"))
            ->line(new HtmlString("<strong>From:</strong> " . $enquiry->name))
            ->line(
                new HtmlString(
                    "<strong>Email:</strong> <a href=\"mailto:" .
                        $enquiry->email .
                        "\">" .
                        $enquiry->email .
                        "</a>"
                )
            )
            ->line(new HtmlString("<strong>Phone:</strong> " . $enquiry->phone))
            ->line(new HtmlString("<strong>Message:</strong><br>" . $enquiry->message))
            ->line(new HtmlString("<hr><br>"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
