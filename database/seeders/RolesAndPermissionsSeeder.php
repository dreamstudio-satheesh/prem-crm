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
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                
                if (!$role->permissions()->where('permissions.id', $permission->id)->exists()) {
                    $role->permissions()->attach($permission);
                }
            }
        }
    }
}
