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
}
