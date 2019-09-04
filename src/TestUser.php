<?php

namespace Cloudest\LaravelEloquentEmailLog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TestUser extends Model
{
    use Notifiable;

    protected $guarded = [];
}
