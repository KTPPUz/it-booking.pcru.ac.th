<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * สร้าง instance พร้อมข้อมูล
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * สร้างเนื้อหาอีเมล
     */
    public function build()
    {
        return $this->subject($this->details['subject'])
            ->view('emails.notifyApproval')
            ->with('details', $this->details);
    }
}