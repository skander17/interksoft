<?php

namespace App\Services;


use App\Repositories\AirportRepository;

class AirportService extends Service
{

    public function __construct(AirportRepository $repository)
    {
        parent::__construct($repository);
    }

}
