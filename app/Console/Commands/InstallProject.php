<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:project {name : The name of the project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the project with migrations and seeders';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $projectName = $this->argument('name');
        
        $this->info("Installing project: {$projectName}");
        
        // Run migrations
        $this->info('Running migrations...');
        $this->call('migrate:fresh');
        
        // Run seeders
        $this->info('Running seeders...');
        $this->call('db:seed');
        
        // Generate JWT secret
        $this->info('Generating JWT secret...');
        $this->call('jwt:secret');
        
        // Clear cache
        $this->info('Clearing cache...');
        $this->call('config:clear');
        $this->call('cache:clear');
        
        $this->info("Project {$projectName} has been installed successfully!");
        
        return Command::SUCCESS;
    }
} 