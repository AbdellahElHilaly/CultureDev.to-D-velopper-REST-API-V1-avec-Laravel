<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Roles
        $adminRole  = Role::create(['name' => 'admin' , 'display_name' => 'Administration' , 'description' => 'Administrator' , 'allowed_route' => 'admin']);
        $authorRole = Role::create(['name' => 'author' , 'display_name' => 'Supervisor' , 'description' => 'Author' , 'allowed_route' => 'admin']);
        $guestRole  = Role::create(['name' => 'guest' , 'display_name' => 'Customer' , 'description' => 'Guest' , 'allowed_route' => null]);
    }
}
