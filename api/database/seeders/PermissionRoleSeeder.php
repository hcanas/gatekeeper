<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        $roles->each(function ($role) use ($permissions) {
            $perms = $permissions->random(rand(1,5))->values();

            foreach ($perms AS $perm) {
                $role->permissions()->attach($perm->id);
            }
        });
    }
}
