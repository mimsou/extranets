<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeComment extends Mailable
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
     * Comment that has been added
     *
     * @var
     */
    public $comment;

    /**
     * Project
     *
     * @var
     */
    public $project;


    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($user, $loggedInUserName, $comment, $project)
    {
        $this->user = $user;
        $this->loggedInUserName = $loggedInUserName;
        $this->comment = $comment;
        $this->project = $project;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.demande.commented');
    }
}