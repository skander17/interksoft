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
        /** @var User $user */
        $user = User::query()->create([
           "name"=>"admin",
           "email"=>"admin@example.com",
           "password"=>Hash::make('password')
        ]);

        $user->assignRole('admin');

        //User::factory()->times(100)->create();
    }
}
