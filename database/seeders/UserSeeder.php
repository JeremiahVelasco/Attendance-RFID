<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Jeremiah Velasco',
            'email' => 'velascojeremiahd@gmail.com',
            'rfid' => '000',
            'role' => 0,
            'password' => 'password'
        ]);

        User::factory(10)->create();
    }
}
