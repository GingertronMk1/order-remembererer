<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModelUpdated extends Mailable
{
    use Queueable, SerializesModels;

    private $type;
    private $model;

    /**
     * Create a new message instance.
     *
     * @return void
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
