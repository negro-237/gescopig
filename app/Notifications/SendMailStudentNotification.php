<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use DB;

class SendMailStudentNotification extends Notification
{
    use Queueable;

    private $full_name;
    private $policy_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($full_name, $policy_id)
    {
        $this->full_name = $full_name;
        $this->policy_id = $policy_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->line('Le statut de l\'apprenant ' . $this->full_name . ' a changé')
                    ->action('Mettre à jour', url('/').'/contrats/'.$this->policy_id.'/edit')
                    ->line('Merci d\'avoir utilisé notre application!');
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
