<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = config('constants.permissions.all');

        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }

        $roles = config('constants.roles.all');
        foreach($roles as $role){
            $role = Role::create(['name' => $role]);
            //$role->givePermissionTo($role['permissions']);
        }
    }
}
