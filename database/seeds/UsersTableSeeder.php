<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
           'name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $manager = User::create([
            'name' => 'Manager',
            'surname' => 'User',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password')
        ]);

        $user = User::create([
            'name' => 'Generic',
            'surname' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($managerRole);
        $user->roles()->attach($userRole);
    }
}
