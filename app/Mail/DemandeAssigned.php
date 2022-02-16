<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $demande;
    public $assigner_name;
    public $user_assigned;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_assigned, $assigner_name, $project, $demande)
    {
        $this->project = $project;
        $this->demande = $demande;
        $this->assigner_name = $assigner_name;
        $this->user_assigned = $user_assigned;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.demande.assigned')->subject("Projet #".$this->project->numero." - Vous avez été assigné à une demande");
    }
}
