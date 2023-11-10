<?php

namespace Database\Seeders;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddAdjustmentAndTrandferPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'manage_adjustments',
                'display_name' => 'Manage Adjustments',
            ],
            [
                'name' => 'manage_transfers',
                'display_name' => 'Manage Transfers',
            ],
        ];
        foreach ($permissions as $permission) {
            $permissionExist = Permission::whereName($permission['name'])->exists();
            if (! $permissionExist) {
                Permission::create($permission);
            }
        }

        /** @var Role $adminRole */
        $adminRole = Role::whereName(Role::ROLE_ADMIN)->first();

        if (empty($adminRole)) {
            $adminRole = Role::create([
                'name' => 'admin',
                'display_name' => ' Admin',
            ]);
        }

        $allPermissions = Permission::pluck('name', 'id');
        $adminRole->syncPermissions($allPermissions);
    }
}
