<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(2)->create();

        User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Task::factory(2)->low()->recycle($users)->create();
        Task::factory(2)->normal()->recycle($users)->create();
        Task::factory(2)->high()->controlAt()->recycle($users)->create();
    }
}
