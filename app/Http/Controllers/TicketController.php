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
        if($request->hasHeader('users')){
            return $this->message(422,"User Required");
        }
        if(!$request->has('code') and empty($request->code)){
            return $this->message(422,"Code Required");
        }
        if(!$request->has('ticket') and empty($request->ticket)){
            return $this->message(422,"ticket Required");
        }
        if(!$request->has('date_start') and empty($request->date_start)){
            return $this->message(422,"Date Start Required");
        }
        if(!$request->has('date_arrival') and empty($request->date_arrival)){
            return $this->message(422,"Date Arrival Required");
        }
        if(!$request->has('airport_origin_id') and empty($request->airport_origin_id)){
            return $this->message(422,"Airport Origin Id Required");
        }
        if(!$request->has('airport_arrival_id') and empty($request->airport_arrival_id)){
            return $this->message(422,"Airport Arrival Id Required");
        }
        if(!$request->has('client_id') and empty($request->client_id)){
            return $this->message(422,"Client Id Required");
        }
        $data = [];
        return count($data)>0 ? $this->repository->store($data) : 'incorrect data';
    }


}
