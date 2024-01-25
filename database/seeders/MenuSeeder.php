<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id'=>1, 'parent_id'=> null ,'uuid'=>Str::uuid(), 'sequence'=>1, 'icon'=>'bi bi-speedometer' ,'name'=>'Dashboard', 'translate'=>'label.dashboard', 'url'=>'dashboard', 'position'=>'0', 'description'=>'This is dashboard page'],

            ['id'=>2, 'parent_id'=> null, 'uuid'=>Str::uuid(), 'sequence'=>2, 'icon'=>'bi bi-windows', 'name'=>'System', 'translate'=> 'label.system', 'url'=>'system/permission', 'position'=>'0', 'description'=>'This is system'],
            ['id'=>3, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>1, 'icon'=>'bi bi-shield-fill', 'name'=>'Permission', 'translate'=>'label.permission', 'url'=>'system/permission', 'position'=>'1', 'description'=>'This is permission page'],
            ['id'=>4, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>2, 'icon'=>'bi bi-diagram-3-fill', 'name'=>'Role', 'translate'=>'label.role', 'url'=>'system/role', 'position'=>'1', 'description'=>'This is role page'],
            ['id'=>5, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>3, 'icon'=>'bi bi-person-fill', 'name'=>'User', 'translate'=>'label.user', 'url'=>'system/user', 'position'=>'1', 'description'=>'This is user page'],
            ['id'=>6, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>4, 'icon'=>'bi bi-layout-text-window-reverse', 'name'=>'Menu', 'translate'=>'label.menu', 'url'=>'system/menu', 'position'=>'1', 'description'=>'This is menu page'],
            ['id'=>7, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>5, 'icon'=>'bi bi-flag-fill', 'name'=>'Country', 'translate'=>'label.country', 'url'=>'system/country', 'position'=>'1', 'description'=>'This is country page'],
            ['id'=>8, 'parent_id'=> 2, 'uuid'=>Str::uuid(), 'sequence'=>6, 'icon'=>'bi bi-translate', 'name'=>'Translate', 'translate'=>'label.translate', 'url'=>'system/translate', 'position'=>'1', 'description'=>'This is translate page'],
        ];
        
        
        Menu::insert($data);
    }
}
