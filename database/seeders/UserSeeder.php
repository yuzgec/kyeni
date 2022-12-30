<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                
                [
                    'name' => 'Olcay Yüzgeç',
                    'email' => 'olcayy@gmail.com',
                    'email_verified_at' => now(),
                    'password' => '$2y$10$Sibwr1vkCSvfjo4e9ryHA.SLy9y0EQ8oG9iUPLjh.zMIjugTOPRjS', // password
                    'remember_token' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'is_admin' => 1

                ]
            ];
        DB::table('users')->insert($data);
    }
}
