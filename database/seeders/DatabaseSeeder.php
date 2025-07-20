<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name'=>'Test Admin',
            'email'=>'Admin@gmail.com',
            'role'=>'admin',
            'password'=>bcrypt('admin')
        ]);

        User::create([
            'name'=>'Test client',
            'email'=>'client@gmail.com',
            'role'=>'client',
            'password'=>bcrypt('client')
        ]);

        User::create([
            'name'=>'Test supervisor',
            'email'=>'supervisor@gmail.com',
            'role'=>'supervisor',
            'password'=>bcrypt('supervisor')
        ]);
        $this->call([
            DummyAutoCheckoutSeeder::class,
            ClientSeeder::class,
            PetugasSeeder::class,
            JobSeeder::class,
        ]);

    }
}
