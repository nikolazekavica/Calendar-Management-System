<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 13.4.2022.
 * Time: 22:56
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username'   => 'admin.test',
                'first_name' => 'test',
                'last_name'  => 'test',
                'password'   => Hash::make('Test123!'),
                'email'      => 'test@test.com',
                'verification_code' => "dasdsadasd",
                'role_id'    => 2
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}