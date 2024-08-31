<?php

namespace Database\Seeders;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::create([
            'name' => 'Sopheak',
            'phone' => '855968590557',
            'password' => Hash::make('123123'),
        ]);
        UserModel::create([
            'name' => 'Developer',
            'phone' => '123123',
            'password' => Hash::make('123123'),
        ]);
        UserModel::factory(10)->create();
    }
}
