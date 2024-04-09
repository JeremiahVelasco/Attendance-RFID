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
            'image' => '/storage/profile-photos/Jeremiah Velasco.jpg',
            'name' => 'Jeremiah Velasco',
            'email' => 'velascojeremiahd@gmail.com',
            'rfid' => '0295745843',
            'role' => 3,
            'password' => 'password'
        ]);
        
        User::factory()->create([
            'image' => '/storage/profile-photos/Kafelnikov Dela Rosa.jpeg',
            'name' => 'Kafelnikov Dela Rosa',
            'email' => 'velascojeremiahd@gmail.com',
            'rfid' => '0135016243',
            'role' => 0,
            'password' => 'password'
        ]);

        User::factory()->create([
            'image' => '/storage/profile-photos/Vernie John Baltazar.png',
            'name' => 'Vernie John Baltazar',
            'email' => 'velascojeremiahd@gmail.com',
            'rfid' => '0253660233',
            'role' => 1,
            'password' => 'password'
        ]);
        // User::factory(10)->create();
    }
}
