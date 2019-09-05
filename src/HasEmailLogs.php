<?php

namespace Cloudest\LaravelEloquentEmailLog;

use Illuminate\Database\Eloquent\Model;

trait HasEmailLogs
{
    public function emailLogs()
    {
        return $this->morphMany(EmailLog::class, 'notifiable');
    }
}
