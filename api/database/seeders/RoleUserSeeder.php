<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $roles = Role::all();

        $users->each(function ($user) use ($roles) {
            $rows = $roles->random(rand(1, 5))->values();

            foreach ($rows AS $row) {
                $user->roles()->attach($row->id);
            }
        });
    }
}
