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
     * @param ?string $input
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function search(?string $input){
        $input = strtolower($input);
        return $this->model::query()->whereRaw(
            "lower(ful_name) LIKE lower(?)",["%$input%"]
        )->orWhereRaw(
            "lower(code) LIKE lower(?)",["%$input%"]
        )->get();
    }
}
