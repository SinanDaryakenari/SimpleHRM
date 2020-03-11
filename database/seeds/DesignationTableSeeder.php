<?php

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Designation::truncate();

        Designation::create(['name' => 'Manager']);
        Designation::create(['name' => 'Manager Assistance']);
        Designation::create(['name' => 'Software Engineer']);
    }
}
