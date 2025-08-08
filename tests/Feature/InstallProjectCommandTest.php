<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class InstallProjectCommandTest extends TestCase
{
    public function test_install_project_command_accepts_name_parameter()
    {
        $this->artisan('install:project', ['name' => 'Test Project'])
            ->expectsOutput('Installing project: Test Project')
            ->expectsOutput('Running migrations...')
            ->expectsOutput('Running seeders...')
            ->expectsOutput('Generating JWT secret...')
            ->expectsOutput('Clearing cache...')
            ->expectsOutput('Project Test Project has been installed successfully!')
            ->assertExitCode(0);
    }

    public function test_install_project_command_requires_name_parameter()
    {
        $this->artisan('install:project')
            ->assertExitCode(1);
    }

    public function test_install_project_command_can_be_called_with_different_names()
    {
        $this->artisan('install:project', ['name' => 'My Laravel App'])
            ->expectsOutput('Installing project: My Laravel App')
            ->expectsOutput('Project My Laravel App has been installed successfully!')
            ->assertExitCode(0);
    }
}
