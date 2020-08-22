<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'role_id' => 1,
                'name' => 'admin',
                'last_name' => 'admin',
                'username' => 'admin_admin',
                'status' => 1,
                'email' => 'admin@admin.com',
                'password' => bcrypt(123456),
            ],
            [
                'role_id' => 2,
                'name' => 'agent',
                'last_name' => 'agent',
                'username' => 'agent_agent',
                'status' => 1,
                'email' => 'agent@agent.com',
                'password' => bcrypt(123456),
            ],
            [
                'role_id' => 3,
                'name' => 'superadmin',
                'last_name' => 'superadmin',
                'username' => 'superadmin_superadmin',
                'status' => 1,
                'email' => 'superadmin@superadmin.com',
                'password' => bcrypt(123456),
            ]
        ];

        foreach($datas as $data){
            User::create($data);
        }

    }
}
