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
}
