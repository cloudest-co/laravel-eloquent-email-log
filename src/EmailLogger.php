<?php

namespace Cloudest\LaravelEloquentEmailLog;

use DB;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;

class EmailLogger
{
    /**
     * Handle the event.
     *
     * @param MessageSent $event
     */
    public function handle(MessageSent $event)
    {
        $message = $event->message;
        $notifiable = $event->data['notifiable'] ?? null;

        DB::table('email_log')->insert([
            'date' => date('Y-m-d H:i:s'),
            'from' => implode(',', array_keys($message->getFrom())),
            'to' => implode(',', array_keys($message->getTo() ?? [])),
            'cc' => implode(',', array_keys($message->getCc() ?? [])),
            'bcc' => implode(',', array_keys($message->getBcc() ?? [])),
            'subject' => $message->getSubject(),
            'body' => $message->getBody(),
            'headers' => json_encode(array_filter(explode("\r\n", $message->getHeaders()->toString()))),
            'notifiable_id' => $notifiable ? $notifiable->getKey() : null,
            'notifiable_type' => $notifiable ? get_class($notifiable) : null,
        ]);
    }
}
