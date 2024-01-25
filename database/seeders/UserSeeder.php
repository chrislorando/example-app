<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => Str::uuid(),
            'role_id' => 1,
            'username' => 'admin',
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'is_deleted' => '0',
            'photo'=> null
        ]);

        User::create([
            'uuid' => Str::uuid(),
            'role_id' => 2,
            'username' => 'johndoe',
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
            'is_deleted' => '0',
            'photo'=> null
        ]);

    }
}
