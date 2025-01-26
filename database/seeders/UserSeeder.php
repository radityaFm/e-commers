<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'user',
            'email' => 'lautan@example.com',
            'password' => bcrypt('seanirma'), // Jangan lupa enkripsi password
        ]);
    }
}

