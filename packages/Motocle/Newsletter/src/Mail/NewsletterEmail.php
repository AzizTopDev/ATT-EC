<?php

namespace Motocle\Newsletter\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $newsletterData;

    public function __construct($newsletterData) {
        $this->newsletterData = $newsletterData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('newsletter::emails.newsletter')
            ->from(env('NEWSLETTER_FROM'), env('NEWSLETTER_FROM_NAME'))
            ->subject($this->newsletterData->subject)
            ->with([
                'token' => isset($this->newsletterData->subscriberToken) ? $this->newsletterData->subscriberToken : 'token',
                'content' => $this->newsletterData->content,
            ]);
    }
}
