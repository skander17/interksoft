<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $admin */
        $admin = Role::query()->create([
            "name"=>"admin"
        ]);



        $admin->syncPermissions([
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
            Permission::create(['name' => 'delete tickets'])
        ]);

        /** @var Role $operator */
        $operator = Role::query()->create([
            "name"=>"operator"
        ]);

        $operator->syncPermissions([
            Permission::query()->where(['name' => 'list clients'])->first(),
            Permission::query()->where(['name' => 'create clients'])->first(),
            Permission::query()->where(['name' => 'show clients'])->first(),
            Permission::query()->where(['name' => 'edit clients'])->first(),
            Permission::query()->where(['name' => 'delete clients'])->first(),
            Permission::query()->where(['name' => 'list countries'])->first(),
            Permission::query()->where(['name' => 'create countries'])->first(),
            Permission::query()->where(['name' => 'show countries'])->first(),
            Permission::query()->where(['name' => 'edit countries'])->first(),
            Permission::query()->where(['name' => 'delete countries'])->first(),
            Permission::query()->where(['name' => 'list airlines'])->first(),
            Permission::query()->where(['name' => 'create airlines'])->first(),
            Permission::query()->where(['name' => 'show airlines'])->first(),
            Permission::query()->where(['name' => 'edit airlines'])->first(),
            Permission::query()->where(['name' => 'delete airlines'])->first(),
            Permission::query()->where(['name' => 'list airports'])->first(),
            Permission::query()->where(['name' => 'create airports'])->first(),
            Permission::query()->where(['name' => 'show airports'])->first(),
            Permission::query()->where(['name' => 'edit airports'])->first(),
            Permission::query()->where(['name' => 'delete airports'])->first(),
            Permission::query()->where(['name' => 'list tickets'])->first(),
            Permission::query()->where(['name' => 'create tickets'])->first(),
            Permission::query()->where(['name' => 'show tickets'])->first(),
            Permission::query()->where(['name' => 'edit tickets'])->first(),
            Permission::query()->where(['name' => 'delete tickets'])->first()
        ]);
        /** @var Role $user */
        $user = Role::query()->create([
            "name"=>"user"
        ]);
        $user->syncPermissions([
            Permission::query()->where(['name' => 'list tickets'])->first(),
            Permission::query()->where(['name' => 'create tickets'])->first(),
            Permission::query()->where(['name' => 'show tickets'])->first(),
            Permission::query()->where(['name' => 'edit tickets'])->first(),
            Permission::query()->where(['name' => 'delete tickets'])->first()
        ]);
    }
}
