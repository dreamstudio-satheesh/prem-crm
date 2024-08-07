<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'username' => 'admin',
            'name' => 'Admin User',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
    }
}
