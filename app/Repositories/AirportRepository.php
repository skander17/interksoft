<?php


namespace App\Repositories;


use App\Models\Airport;

class AirportRepository extends Repository
{

    public function __construct(Airport $model)
    {
        parent::__construct($model);
    }


    public function index()
    {
        return $this->model::with('country')->get();
    }

    /**
     * @param string|null $input
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $input){
        $input = strtolower($input);
        return $this->model::query()->whereRaw(
            "lower(name) LIKE lower(?)",["%$input%"]
        )->orWhereRaw(
            "lower(iata_code) LIKE lower(?)",["%$input%"]
        )->get();
    }

}
