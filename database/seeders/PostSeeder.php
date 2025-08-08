<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {

            $postCount = rand(2, 5);
            
            for ($i = 0; $i < $postCount; $i++) {
                Post::create([
                    'user_id' => $user->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraphs(rand(1, 3), true),
                    'contact_phone' => fake()->phoneNumber(),
                ]);
            }
        }
    }
} 