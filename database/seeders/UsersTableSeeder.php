<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $admin */
        $admin = User::query()->create([
           "name"=>"Administrador",
           "email"=>"admin@intercasas.com",
           "password"=>Hash::make('je8t7r9f')
        ]);

        $admin->assignRole('admin');

        /** @var User $operator */
        $operator = User::query()->create([
            "name"=>"Administrador",
            "email"=>"admin@intercasas.com",
            "password"=>Hash::make('tezfw5h9')
        ]);

        $operator->assignRole('operator');

        /** @var User $user */
        $user = User::query()->create([
            "name"=>"Administrador",
            "email"=>"admin@intercasas.com",
            "password"=>Hash::make('tg7ghpa7')
        ]);

        $user->assignRole('user');
    }
}
