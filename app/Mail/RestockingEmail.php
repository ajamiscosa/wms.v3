<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestockingEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Path to CSV
     *
     * @var Path
     */
    protected $path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.restock');
    }
}
