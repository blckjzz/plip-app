<?php

namespace App\Notifications;

use App\Volunteer;
use http\Client\Curl\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;

class NewUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Volunteer $volunteer, $password)
    {
        $this->volunteer = $volunteer;
        $this->password = $password;
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
            ->subject('Credenciais Mudamos+')
            ->greeting('Olá, ' . $this->volunteer->user->name.'!')
            ->line('Seja bem-vindo ao Sistema de Voluntários do Mudamos+.')
            ->line('Seguem suas credenciais de acesso ao Sistema de Análise de Projetos.')
            ->line("Login de acesso: ". $this->volunteer->user->email)
            ->line('Senha: '. $this->password)
            ->action('Entrar no sistema', route('login'))
            ->salutation('Qualquer problema com acesso entrar em contato com diego@itsrio.org');
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
