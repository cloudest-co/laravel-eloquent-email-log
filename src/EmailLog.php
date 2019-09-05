<?php

namespace Cloudest\LaravelEloquentEmailLog;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'email_log';

    public $timestamps = false;

    protected $casts = [
        'date' => 'dateTime',
        'headers' => 'array',
    ];

    public function notifiable()
    {
        return $this->morphTo('notifiable');
    }
}
