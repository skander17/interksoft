<?php

namespace App\Http\Controllers;

use App\Repositories\AirlineRepository;
use Illuminate\Http\Request;

class AirlineController extends Controller
{

    protected array $storeRules = [
        'ful_name' => ['required']
    ];
    protected array $messages = [
        'ful_name.required'
    ];

    protected array $alias = [
        "id"        => "ID",
        "ful_name"  =>"Nombre",
        "code"      =>"Codigo IATA",
        "description" =>"Descripción" ,
    ];
    protected string $reportTitle = "Reporte de Aerolineas";
    public function __construct(AirlineRepository $repository)
    {
        $this->name = 'airline';
        parent::__construct($repository);
    }

    public function index(AirlineRepository $repository)
    {
        //init Log
            $this->action = 'List Client View';
        //
        return view('airlines.index', ['airlines' => $repository->index()]);
    }

    public function search(Request $request){
        //init Log
        $this->action = 'Search Client';
        //
        $result = $this->repository->search($request->input('search'));
        return response()->json($result);
    }

}
