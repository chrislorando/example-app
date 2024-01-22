<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 1,
            'uuid' => Str::uuid(),
            'name' => 'SUPERUSER',
            'description' => 'High level user account',
            'guard_name' => 'web'
        ]);

        Role::create([
            'id' => 2,
            'uuid' => Str::uuid(),
            'name' => 'STAFF',
            'description' => 'Staff user account',
            'guard_name' => 'web'
        ]);
    }
}
