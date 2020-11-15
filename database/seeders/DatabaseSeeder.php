<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeed::class,
            RolesSeed::class,
            UsersTableSeeder::class,
            ClientSeed::class,
            CountrySeed::class,
            AirportSeed::class
        ]);

    }
}
