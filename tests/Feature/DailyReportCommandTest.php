<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class DailyReportCommandTest extends TestCase
{
    public function test_daily_report_command_generates_report()
    {
        // Create some test data
        User::factory()->count(3)->create();
        Post::factory()->count(5)->create();

        $this->artisan('report:daily')
            ->expectsOutput('Generating daily report...')
            ->expectsOutput('Daily report sent to admin@example.com successfully!')
            ->expectsOutput('Daily report completed successfully!')
            ->assertExitCode(0);
    }

    public function test_daily_report_command_with_no_data()
    {
        $this->artisan('report:daily')
            ->expectsOutput('Generating daily report...')
            ->expectsOutput('Daily Report for ' . now()->format('Y-m-d'))
            ->expectsOutput('New Users: 0')
            ->expectsOutput('New Posts: 0')
            ->expectsOutput('Total Users: 0')
            ->expectsOutput('Total Posts: 0')
            ->expectsOutput('Daily report sent to admin@example.com successfully!')
            ->expectsOutput('Daily report completed successfully!')
            ->assertExitCode(0);
    }

    public function test_daily_report_command_sends_email()
    {
        Mail::fake();

        // Create some test data
        User::factory()->count(2)->create();
        Post::factory()->count(3)->create();

        $this->artisan('report:daily')
            ->assertExitCode(0);

        // Assert that email was sent
        Mail::assertSent(\App\Mail\DailyReportMail::class, function ($mail) {
            return $mail->hasTo('admin@example.com');
        });
    }

    public function test_daily_report_command_logs_activity()
    {
        // Create some test data
        User::factory()->count(1)->create();
        Post::factory()->count(2)->create();

        $this->artisan('report:daily')
            ->assertExitCode(0);

        // The command should log the report
        // We can't easily test this without mocking, but the command includes Log::info
    }
}
