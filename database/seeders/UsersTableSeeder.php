<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminadmin'),
            'address' => 'inEcommerceWebSite',
            'image' => null,
            'bio' => 'Hey I am admin',
            'phone' => '0771452173',
            'is_superuser' => 1,
            'is_staff' => 0,
        ];

        User::create($adminUser);
    }
}
