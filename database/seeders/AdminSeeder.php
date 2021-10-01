<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'nama' => 'Sansan',
            'no_hp' => '0123456789',
            'level_id' => 1
        ]);
    }
}
