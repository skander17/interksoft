<?php

namespace App\Http\Controllers;

use App\Repositories\AirportRepository;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    protected array $alias = [
        "id" => "ID",
        "name"=>"Nombre",
        "iso_region" =>"Codigo ISO" ,
        "iata_code" =>"Codigo IATA"
    ];
    protected string $reportTitle = "Reporte de Aeropuertos";
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

    public function search(Request $request){
        $result = $this->repository->search($request->input('search'))->toArray();
        return response()->json($result);
    }
}
