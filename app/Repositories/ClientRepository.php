<?php


namespace App\Repositories;


use App\Models\Client;

class ClientRepository extends Repository
{

    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

    /**
     * @param ?string $name
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $name){
        return $this->model::query()->whereRaw(
            "lower(full_name) LIKE lower(?)",["%$name%"]
        )->get();
    }
}
