<?php

namespace Motocle\Newsletter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use Motocle\Newsletter\Mail\NewsletterEmail;
use Webkul\Core\Models\SubscribersList;

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newsletterData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($newsletterData)
    {
        $this->newsletterData = $newsletterData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = SubscribersList::where('is_subscribed', 1)
            ->get();

        foreach ($subscribers as $subscriber) {
            $this->newsletterData->subscriberToken = $subscriber->token;

            $newsletter = (new NewsletterEmail($this->newsletterData))
                ->onConnection('database')
                ->onQueue('newsletter');

            Mail::to($subscriber->email)
                ->queue($newsletter);
        }
    }
}
