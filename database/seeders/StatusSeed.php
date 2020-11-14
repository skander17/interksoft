<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StatusSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::query()->create([
            "name"=>"Pedido",
            "entity"=>"ticket"
        ]);

        State::query()->create([
            "name"=>"Aprobado",
            "entity"=>"ticket"
        ]);

        State::query()->create([
            "name"=>"Conciliado",
            "entity"=>"ticket"
        ]);
    }
}
