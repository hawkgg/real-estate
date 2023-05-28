<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin Seeder
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);
        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $admin->assignRole([$role->id]);
        $admin->syncPermissions($permissions);


        //Manager Seeder
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('password')
        ]);
        $role = Role::create(['name' => 'manager']);
        $permissions = Permission::where('name', 'like', '.index')->orWhere('name', 'like', '.show')->pluck('id');
        $role->syncPermissions($permissions);
        $manager->assignRole([$role->id]);
    }
}
