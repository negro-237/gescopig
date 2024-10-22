<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CreateUserAccountNotification extends Notification
{
    use Queueable;

    private $email;
    private $password;
    private $name;

   /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $password, $name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
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
                    ->subject('Compte Utilisateur pour ' .  $this->name)
                    ->line('Votre compte a été crée avec les identifiants suivants: ')
                    ->line('Email: ' . $this->email)
                    ->line('Password: ' . $this->password)
                    ->line('Vous devez changer ce mot de passe à votre premiere connexion')
                    ->action('Cliquez pour vous connecter', route('home'))
                    ->line('Pigier! une école agile');
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
