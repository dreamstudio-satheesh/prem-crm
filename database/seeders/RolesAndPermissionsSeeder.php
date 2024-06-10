<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Admin',
            'Sales',
            'Support'
        ];

        $permissions = [
            'create_user',
            'delete_user',
            'view_sales',
            'manage_orders'
        ];

        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->permissions()->attach($permission);
            }
        }
    }
}
