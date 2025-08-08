<?php

namespace App\Console\Commands;

use App\Mail\DailyReportMail;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report of new posts and users to admin';

    /**
     * Execute the console command.
     */
    public function handle(UserRepository $userRepository, PostRepository $postRepository): int
    {
        $this->info('Generating daily report...');
        
        try {
            $newUsersCount = $userRepository->getTodayCount();
            $newPostsCount = $postRepository->getTodayCount();
            $totalUsers = $userRepository->getCount();
            $totalPosts = $postRepository->getCount();
            
            $report = [
                'date' => now()->format('Y-m-d'),
                'new_users' => $newUsersCount,
                'new_posts' => $newPostsCount,
                'total_users' => $totalUsers,
                'total_posts' => $totalPosts,
            ];
            
            $this->info("Daily Report for " . $report['date']);
            $this->info("New Users: {$newUsersCount}");
            $this->info("New Posts: {$newPostsCount}");
            $this->info("Total Users: {$totalUsers}");
            $this->info("Total Posts: {$totalPosts}");
            
            $adminEmail = config('mail.admin_email', 'admin@example.com');
            
            Mail::to($adminEmail)->send(new DailyReportMail($report));
            
            $this->info("Daily report sent to {$adminEmail} successfully!");
            $this->info('Daily report completed successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate daily report: ' . $e->getMessage());
            Log::error('Daily report generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
} 