<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModelUpdated extends Mailable
{
    use Queueable;
    use SerializesModels;

    private $type;
    private $model;

    /**
     * Create a new message instance.
     *
     * @param mixed $type
     * @param mixed $model
     */
    public function __construct($type, $model)
    {
        $this->type = $type;
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view("emails.admin-observed.{$this->type}");
    }
}
