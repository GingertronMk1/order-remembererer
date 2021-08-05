<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseInvitationNotification extends Notification
{
    use Queueable;

    private $purchaseInvitation;

    /**
     * Create a new notification instance.
     *
     * @param mixed $purchaseInvitation
     */
    public function __construct($purchaseInvitation)
    {
        $this->purchaseInvitation = $purchaseInvitation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action(
                'Accept Invitation',
                url(
                    route(
                        'purchase-invitation.edit',
                        ['purchase_invitation' => $this->purchaseInvitation]
                    )
                )
            )
            ->line('Thank you for using our application!')
        ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'purchaseInvitation' => $this->purchaseInvitation,
        ];
    }
}
