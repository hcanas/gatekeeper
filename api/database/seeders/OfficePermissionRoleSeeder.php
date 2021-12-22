<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\PermissionRole;
use Illuminate\Database\Seeder;

class OfficePermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_roles = PermissionRole::all();
        $offices = Office::all();

        $permission_roles->each(function ($permission_role) use ($offices) {
            $off = $offices->random(rand(1,3))->values();

            foreach ($off AS $office) {
                $permission_role->offices()->attach($office->id);
            }
        });
    }
}
