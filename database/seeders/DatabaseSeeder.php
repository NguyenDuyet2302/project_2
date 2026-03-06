<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::where('email', 'admin@gmail.com')->count() == 0) {
            User::create([
                'fullname' => 'Admin Quản Lý',
                'email'    => 'admin@gmail.com',
                'phone'    => '0987654321',
                'id_card'  => '012345678912',
                'address'  => 'Hà Nội', // Bổ sung thêm địa chỉ vào đây
                'role'     => '1',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
