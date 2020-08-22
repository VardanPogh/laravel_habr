<?php

use App\UserRoles;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name'=>'admin'],
            ['name'=>'agent']
        ];

        foreach($roles as $role) {
            UserRoles::create($role);
        }
    }
}
