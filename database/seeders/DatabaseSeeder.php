<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
            UsersTableSeeder::class,
            ClientSeed::class,
            CountrySeed::class,
            AirportSeed::class
        ]);

    }
}
