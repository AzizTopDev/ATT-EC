<?php

namespace Motocle\Email\Listeners;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\View;
use Motocle\Email\Models\SystemEmail;

class EmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        if (isset($event->data['se_template'])) {
            $emailTemplate = SystemEmail::where('type', $event->data['se_template'])->first();

            if ($emailTemplate) {
                if (!empty($emailTemplate->content)) {
                    $emailTemplate->content = $this->replaceBBcodes($emailTemplate->content, unserialize($emailTemplate->variables));
                    $event->data['content'] = $emailTemplate;
                    $event->message->setBody(View::make('email::emails.' . $event->data['se_template'], $event->data));
                }

                if (!empty($emailTemplate->subject)) {
                    $event->message->setSubject($emailTemplate->subject);
                }

                if (!empty($emailTemplate->sender_email)) {
                    $event->message->setFrom($emailTemplate->sender_email, $emailTemplate->sender_name);
                }
            }
        }
    }

    protected function replaceBBcodes($text, $validVariables = [])
    {
        $buttonStyle = 'padding: 10px 20px;background: blue;color: #ffffff;text-transform: uppercase;text-decoration: none; font-size: 16px';

        $find = [
            '/(\[url=)(.*?)(\])(.*?)(\[\/url\])/',
            '/(\[url\])(.*?)(\[\/url\])/',
            '/(\[btn_url=)(.*?)(\])(.*?)(\[\/btn_url\])/',
        ];

        $replace = [
            '<a href="$2" target="_blank">$4</a>',
            '<a href="$2" target="_blank">$2</a>',
            '<a href="$2" target="_blank" style="' . $buttonStyle . '">$4</a>',
            '{!! $$2 !!}'
        ];

        $newText = preg_replace($find, $replace, $text);

        preg_match_all('/(\{)(.*?)(\})/', $text, $matches);

        foreach ($matches[2] as $match) {
            if (in_array($match, $validVariables)) {
                $newText = preg_replace('/(\{)' . $match . '(\})/', '{!! $' . $match . ' !!}', $newText);
            }
        }

        return $newText;
    }
}
