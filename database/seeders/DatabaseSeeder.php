<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\Image;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function (User $user) {
            Blog::factory(10)->create(['user_id' => $user->id]);
            Image::factory(10)->create(['user_id' => $user->id]);
        });
    }
}
