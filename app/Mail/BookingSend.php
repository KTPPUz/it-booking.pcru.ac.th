<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSend extends Mailable
{
    use Queueable, SerializesModels;

    public $booking; 

    /**
     * Create a new message instance.
     *
     * @param mixed $booking
     */
    public function __construct($booking)
    {
        $this->booking = $booking; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Booking Has Been Unsent')
                    ->view('emails.booking_send')
                    ->with([
                        'booking' => $this->booking, 
                    ]);
    }
}