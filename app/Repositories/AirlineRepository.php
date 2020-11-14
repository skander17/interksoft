<?php


namespace App\Repositories;


use App\Models\Airline;

class AirlineRepository extends Repository
{
    public function __construct(Airline $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model::all();
    }

    /**
     * @param ?string $name
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $input){
        return $this->model::query()->whereRaw(
            "lower(name) LIKE lower(?)",["%$input%"]
        )->orWhereRaw(
            "lower(code) LIKE lower(?)",["%$input%"]
        )->get();
    }
}
