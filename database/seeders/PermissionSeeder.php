<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('permissions')->truncate();
        
        $data = [
            ['id'=>1, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'dashboard.index', 'alias'=>'dashboard', 'controller'=>'App\Livewire\Dashboard', 'action'=>'index', 'description'=>'Dashboard management page'],
            ['id'=>2, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.index', 'alias'=>'system/user', 'controller'=>'App\Livewire\System\User', 'action'=>'index', 'description'=>'User management page'],
            ['id'=>3, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.create', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'create', 'description'=>'User create action'],
            ['id'=>4, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.store', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'store', 'description'=>'User store action'],
            ['id'=>5, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'edit', 'description'=>'User edit action'],
            ['id'=>6, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.update', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'update', 'description'=>'User update action'],
            ['id'=>7, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'delete', 'description'=>'User delete action'],
            ['id'=>8, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.deletePhoto', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'deletePhoto', 'description'=>'User delete photo action'],
            ['id'=>9, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.show', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'view', 'description'=>'User view action'],
            ['id'=>10, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.user.restore', 'alias'=>null, 'controller'=>'App\Livewire\System\User', 'action'=>'restore', 'description'=>'User restore action'],

            ['id'=>11, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.index', 'alias'=>'system/role', 'controller'=>'App\Livewire\System\Role', 'action'=>'index', 'description'=>'Role management page'],
            ['id'=>12, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.create', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'create', 'description'=>'Role create action'],
            ['id'=>13, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.store', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'store', 'description'=>'Role store action'],
            ['id'=>14, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'edit', 'description'=>'Role edit action'],
            ['id'=>15, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.update', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'update', 'description'=>'Role update action'],
            ['id'=>16, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'delete', 'description'=>'Role delete action'],
            ['id'=>17, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.show', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'view', 'description'=>'Role view action'],
            ['id'=>18, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.permission', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'permission', 'description'=>'Role permission action'],
            ['id'=>19, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.restore', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'restore', 'description'=>'Role restore action'],
            ['id'=>20, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.role.copy', 'alias'=>null, 'controller'=>'App\Livewire\System\Role', 'action'=>'copy', 'description'=>'Role copy action'],

            ['id'=>21, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.index', 'alias'=>'system/permission', 'controller'=>'App\Livewire\System\Permission', 'action'=>'index', 'description'=>'Permission management page'],
            ['id'=>22, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.create', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'create', 'description'=>'Permission create action'],
            ['id'=>23, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.store', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'store', 'description'=>'Permission store action'],
            ['id'=>24, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'edit', 'description'=>'Permission edit action'],
            ['id'=>25, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.update', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'update', 'description'=>'Permission update action'],
            ['id'=>26, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'delete', 'description'=>'Permission delete action'],
            ['id'=>27, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.permission.generate', 'alias'=>null, 'controller'=>'App\Livewire\System\Permission', 'action'=>'generate', 'description'=>'Permission generate action'],

            ['id'=>28, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.index', 'alias'=>'system/menu', 'controller'=>'App\Livewire\System\Menu', 'action'=>'index', 'description'=>'Menu management page'],
            ['id'=>29, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.create', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'create', 'description'=>'Menu create action'],
            ['id'=>30, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.store', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'store', 'description'=>'Menu store action'],
            ['id'=>31, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'edit', 'description'=>'Menu edit action'],
            ['id'=>32, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.update', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'update', 'description'=>'Menu update action'],
            ['id'=>33, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'delete', 'description'=>'Menu delete action'],
            ['id'=>34, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.menu.restore', 'alias'=>null, 'controller'=>'App\Livewire\System\Menu', 'action'=>'restore', 'description'=>'Menu restore action'],

            ['id'=>35, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.index', 'alias'=>'system/country', 'controller'=>'App\Livewire\System\Country', 'action'=>'index', 'description'=>'Country management page'],
            ['id'=>36, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.create', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'create', 'description'=>'Country create action'],
            ['id'=>37, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.store', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'store', 'description'=>'Country store action'],
            ['id'=>38, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'edit', 'description'=>'Country edit action'],
            ['id'=>39, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.update', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'update', 'description'=>'Country update action'],
            ['id'=>40, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'delete', 'description'=>'Country delete action'],
            ['id'=>41, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.deletePhoto', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'deletePhoto', 'description'=>'Country delete photo action'],
            ['id'=>42, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.country.restore', 'alias'=>null, 'controller'=>'App\Livewire\System\Country', 'action'=>'restore', 'description'=>'Country restore action'],

            ['id'=>43, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.index', 'alias'=>'system/translate', 'controller'=>'App\Livewire\System\Translate', 'action'=>'index', 'description'=>'Translate management page'],
            ['id'=>44, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.create', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'create', 'description'=>'Translate create action'],
            ['id'=>45, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.store', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'store', 'description'=>'Translate store action'],
            ['id'=>46, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.edit', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'edit', 'description'=>'Translate edit action'],
            ['id'=>47, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.update', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'update', 'description'=>'Translate update action'],
            ['id'=>48, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.delete', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'delete', 'description'=>'Translate delete action'],
            ['id'=>49, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.restore', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'restore', 'description'=>'Translate restore action'],
            ['id'=>50, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.publish', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'publish', 'description'=>'Translate publish action'],
            ['id'=>51, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'system.translate.backup', 'alias'=>null, 'controller'=>'App\Livewire\System\Translate', 'action'=>'backup', 'description'=>'Translate backup action'],

            ['id'=>52, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'account.profile.index', 'alias'=>null, 'controller'=>'App\Livewire\Account\Profile', 'action'=>'index', 'description'=>'Profile management page'],
            ['id'=>53, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'account.profile.update', 'alias'=>null, 'controller'=>'App\Livewire\Account\Profile', 'action'=>'update', 'description'=>'Profile update action'],
            ['id'=>54, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'account.profile.deletePhoto', 'alias'=>null, 'controller'=>'App\Livewire\Account\Profile', 'action'=>'deletePhoto', 'description'=>'Profile delete photo action'],
            ['id'=>55, 'uuid'=>Str::uuid(), 'guard_name'=>'web', 'name'=>'account.profile.updatePassword', 'alias'=>null, 'controller'=>'App\Livewire\Account\Profile', 'action'=>'updatePassword', 'description'=>'Profile update password action'],
        ];
        
        Permission::insert($data);
    }
}
