<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class BookingReviewed extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Your Booking Has Been Reviewed')
            ->view('emails.booking_reviewed');
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }

}