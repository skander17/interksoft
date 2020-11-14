<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected array $storeRules = [
        'client_id' => ['required'],
        'airport_origin_id' => ['required'],
        'airport_arrival_id' => ['required'],
        'date_start' => ['required'],
        'date_arrival' => ['required'],
        'ticket' => ['required'],
        'airline_id' => ['required']
    ];
    protected array  $messages = [
        'client_id.required' => "El Cliente es requerido",
        'airport_origin_id.required' => "El Aeropuerto de Origen es requerido",
        'airport_arrival_id.required' => "El Aeropuerto de Destino es requerido",
        'date_start.required' => "La fecha de salida es requerida",
        'date_arrival.required' => "La fecha de llegada es requerida",
        'ticket.required' => "El boleto es requerido",
        'airline_id.required' => "La Aerolinea es requerida",
    ];
    protected string $name = 'ticket';
    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }

    public function index(Request $request){
        $tickets = $this->repository->index();
        return view('tickets.index',["tickets" => $tickets]);
    }

    public function store(Request $request)
    {
        return $this->repository->store($request);
    }


}
