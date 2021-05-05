<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Send Email To All Assignees of Demande after any update in Demande
 *
 * Class DemandeUpdate
 * @package App\Mail
 */
class DemandeUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User that is assigned to demande
     * @var
     */
    public $user;

    /**
     * LoggedInUser who made the change in demande
     *
     * @var
     */
    public $loggedInUserName;

    /**
     * List of updated fields Updated Fields
     *
     * @var
     */
    public $fieldsToUpdate;

    /**
     * Demande that has been updated
     *
     * @var
     */
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
