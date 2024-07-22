<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public static $createdUsers;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::$createdUsers = User::factory()->count(20)->create();
    }
}
