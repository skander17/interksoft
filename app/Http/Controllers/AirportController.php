<?php

namespace App\Http\Controllers;

use App\Repositories\AirportRepository;
use App\Repositories\CountryRepository;

class AirportController extends Controller
{
    public function __construct(AirportRepository $repository)
    {
        $this->name = 'airport';
        parent::__construct($repository);
    }

    public function index(CountryRepository $countryRepository){
        $airports =   $this->repository->index();
        $countries =  $countryRepository->index();
        return view('airports.index',['airports'=>$airports,'countries'=>$countries]);
    }
}
