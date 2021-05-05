<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loggedInUserName;
    public $fieldsToUpdate;
    public $modelToUpdate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$loggedInUserName,$fieldsToUpdate,$modelToUpdate)
    {
        $this->user = $user;
        $this->loggedInUserName = $loggedInUserName;
        $this->fieldsToUpdate = $fieldsToUpdate;
        $this->modelToUpdate = $modelToUpdate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.demande.updated');
    }
}
