<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $users = [
            [
                'rol' => 'admin',
                'name' => 'Admin Usuari',
                'email' => 'admin@icv.cat',
                'password' => Hash::make('123'),
            ],
            [
                'rol' => 'professor',
                'name' => 'Professor Usuari',
                'email' => 'professor@icv.cat',
                'password' => Hash::make('123'),
            ],
        ];

        foreach($users as $user){
            User::create($user);
        }

        $this->command->info('3 usuaris creats, password:123');
    }
}
