<?php

namespace Database\Seeders;

use App\Ahkas\Domain\Brand\BrandModel;
use App\Ahkas\Domain\User\UserAdminModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserAdminModel::create([
            'name' => 'Puthi',
            'email' => 'dev.puthi@gmail.com',
            'password' => Hash::make('123123'),
        ]);
    }
}
