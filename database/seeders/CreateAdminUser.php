<?php

namespace Database\Seeders;

use Curfle\Database\Seeding\Seeder;
use Curfle\Support\Facades\DB;
use Curfle\Support\Facades\Hash;

class CreateAdminUser extends Seeder
{

    /**
     * Runs the seeder.
     */
    public function run(): void
    {
        DB::table("user")->insert([
            "firstname" => "Admin",
            "lastname" => "User",
            "email" => "user@admin",
            "password" => Hash::hash("admin"),
        ]);
    }
}