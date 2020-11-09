<?php


namespace App\Repositories;


use App\Models\Country;

class CountryRepository extends Repository
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }

}
