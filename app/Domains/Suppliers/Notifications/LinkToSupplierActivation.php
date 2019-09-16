<?php

namespace App\Domains\Suppliers\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LinkToSupplierActivation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  \App\Units\Auth\User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->greeting(Lang::get("Olá {$notifiable->name}"))
            ->subject(Lang::get('Ativação Fornecedor'))
            ->line(Lang::get('Você está recebendo este e-mail porque recebemos uma solicitação de ativação do seu novo registro de fornecedor.'))
            ->line(Lang::get('Por favor, clique no botão abaixo para ativar sua nova conta de fornecedor.'))
            ->action(Lang::get('Ativar Conta'), $verificationUrl)
            ->line(Lang::get('Se você não solicitou sua ativação, nenhuma ação adicional é necessária.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'suppliers.activation',
            now()->addMinutes(120),
            ['supplierKey' => $notifiable->getKey()]
        );
    }
}
