<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'user']);
    }
}
