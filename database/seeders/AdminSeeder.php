<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insertGetId([
            'avatar' => 'l.png',
            'role' => 'admin',
            'email' => 'admin@easytuition.com',
            'password' => bcrypt('admin')
        ]);

        DB::table('admin')->insert([
            'user_id' => $user,
            'nama' => 'Admin',
            'telepon' => '081385042665'
        ]);
    }
}
