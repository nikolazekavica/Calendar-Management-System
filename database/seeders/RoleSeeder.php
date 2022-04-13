<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 13.4.2022.
 * Time: 22:30
 */

namespace Database\Seeders;


use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'regular'],
            ['name' => 'admin']
        ];
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}