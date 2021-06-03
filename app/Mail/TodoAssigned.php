<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TodoAssigned extends Mailable
{
    use Queueable, SerializesModels;

    protected $user  = '';

    protected $todo = '';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $todo)
    {
        $this->user = $user;
        $this->todo = $todo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.todo.assigned',['user'=>$this->user,'projetId'=>$this->todo->projet_id])->subject("Tout #".$this->todo->to_do." - qui vous a été attribué");
    }
}
