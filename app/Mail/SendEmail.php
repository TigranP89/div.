<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
  use Queueable, SerializesModels;


  /**
   * SendEmail constructor.
   * @param $mailData
   */
  public function __construct(private $mailData)
  {
   //
  }

  /**
   * @return Envelope
   */
  public function envelope(): Envelope
  {
      return new Envelope(
          subject: 'Send Email',
      );
  }

  /**
   * @return Content
   */
  public function content(): Content
  {
    /*
    * @var array $mailData mail data
    */
    return new Content(
        view: 'mail.email',
        with: ['mailData' => $this->mailData],
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
      return [];
  }
}
