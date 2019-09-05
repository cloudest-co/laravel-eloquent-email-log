<?php

namespace Cloudest\LaravelEloquentEmailLog\Tests;

use Carbon\Carbon;
use Cloudest\LaravelEloquentEmailLog\LaravelEloquentEmailLogServiceProvider;
use Cloudest\LaravelEloquentEmailLog\TestUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;

class LaravelEloquentEmailLogTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [LaravelEloquentEmailLogServiceProvider::class];
    }

    /** @test */
    public function the_notification_is_logged_along_with_the_notifiable()
    {
        $message = (new \Swift_Message('Test Subject', 'Test Body'))
            ->setTo('user@example.com', 'Example Recipient')
            ->setFrom('app@cloudest.co.uk', 'Cloudest')
            ->setCC('cc@example.com')
            ->setBCC('bcc@example.com');

        Event::dispatch(new MessageSent($message, ['notifiable' => new TestUser(['id' => 999])]));

        $this->assertDatabaseHas('email_log', [
            'date' => Carbon::now(),
            'from' => 'app@cloudest.co.uk',
            'to' => 'user@example.com',
            'cc' => 'cc@example.com',
            'bcc' => 'bcc@example.com',
            'subject' => 'Test Subject',
            'body' => 'Test Body',
            'notifiable_id' => 999,
            'notifiable_type' => TestUser::class,
        ]);
    }
}
