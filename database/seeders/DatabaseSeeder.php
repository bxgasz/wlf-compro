<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'email' => 'test@example.com',
            'role' => 'admin',
            'name' => 'admin',
            'is_active' => true,
            'profile_pic' => asset('assets/img/default-profile-pic.jpg'),
            'password' => Hash::make('password')
        ]);

        Setting::create([
            'title' => 'wlf',
            'favicon' => asset('assets/img/wlf-icon.png'),
            'logo' => asset('assets/img/wlf-icon.png'),
        ]);
    }
}
