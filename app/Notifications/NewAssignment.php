<?php

namespace App\Notifications;

use App\Analysis;
use App\Volunteer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;


class NewAssignment extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Volunteer $volunteer, Analysis $assignment)
    {
        $this->volunteer = $volunteer;
        $this->assignment = $assignment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nova tarefa - Projeto: ' . Str::limit($this->assignment->petition->name, 20))
            ->greeting('Olá, ' . $this->volunteer->user->name)
            ->line('A Equipe Mudamos+ acaba de cadastrar uma nova tarefa para você <3')
            ->line("Dá uma olhadinha clicando no botão abaixo para saber mais sobre o projeto")
            ->line($this->assignment->petition->name)
            ->action('Veja detalhes do Projeto', action('VolunteerController@viewPetitionDetails', $this->assignment->petition->id))
            ->salutation('Se tiver dúvida é só chamar!');
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
