<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $superadmin */
        $superadmin = Role::query()->create([
            "name"=>"superadmin"
        ]);



        $superadmin->syncPermissions([
            Permission::create(['name' => 'list users']),
            Permission::create(['name' => 'create users']),
            Permission::create(['name' => 'show users']),
            Permission::create(['name' => 'edit users']),
            Permission::create(['name' => 'delete users']),
            Permission::create(['name' => 'list clients']),
            Permission::create(['name' => 'create clients']),
            Permission::create(['name' => 'show clients']),
            Permission::create(['name' => 'edit clients']),
            Permission::create(['name' => 'delete clients']),
            Permission::create(['name' => 'list countries']),
            Permission::create(['name' => 'create countries']),
            Permission::create(['name' => 'show countries']),
            Permission::create(['name' => 'edit countries']),
            Permission::create(['name' => 'delete countries']),
            Permission::create(['name' => 'list airlines']),
            Permission::create(['name' => 'create airlines']),
            Permission::create(['name' => 'show airlines']),
            Permission::create(['name' => 'edit airlines']),
            Permission::create(['name' => 'delete airlines']),
            Permission::create(['name' => 'list airports']),
            Permission::create(['name' => 'create airports']),
            Permission::create(['name' => 'show airports']),
            Permission::create(['name' => 'edit airports']),
            Permission::create(['name' => 'delete airports']),
            Permission::create(['name' => 'list tickets']),
            Permission::create(['name' => 'create tickets']),
            Permission::create(['name' => 'show tickets']),
            Permission::create(['name' => 'edit tickets']),
            Permission::create(['name' => 'delete tickets']),
            Permission::create(['name' => 'list backup']),
            Permission::create(['name' => 'create backup']),
            Permission::create(['name' => 'show backup']),
            Permission::create(['name' => 'edit backup']),
            Permission::create(['name' => 'delete backup'])
        ]);

        /** @var User $superadmin */
        $superadmin = User::query()->create([
            "name"=>"super administrador",
            "email"=>"superadmin@intercasas.com",
            "password"=>Hash::make('hdjalskd31')
        ]);

        $superadmin->assignRole('superadmin');

    }
}
