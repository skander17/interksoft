<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use App\Services\ReportService;
use App\Services\TicketService;
use Illuminate\Http\Request;
/** @property TicketRepository $repository */
class TicketController extends Controller
{
    protected array $storeRules = [
        'client_id'         => ['required'],
        'airport_origin_id' => ['required'],
        'airport_arrival_id'=> ['required'],
        'date_start'        => ['required'],
        'date_arrival'      => ['required'],
        'ticket'            => ['required','unique:tickets'],
        'airline_id'        => ['required']
    ];
    protected array  $messages = [
        'client_id.required'          => "El Cliente es requerido",
        'airport_origin_id.required'  => "El Aeropuerto de Origen es requerido",
        'airport_arrival_id.required' => "El Aeropuerto de Destino es requerido",
        'date_start.required'         => "La fecha de salida es requerida",
        'date_arrival.required'       => "La fecha de llegada es requerida",
        'ticket.required'             => "El boleto es requerido",
        'airline_id.required'         => "La Aerolinea es requerida",
        'ticket.unique'               => "El boleto ya se encuentra registrado",
    ];
    protected string $name = 'ticket';

    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        /** Init log */
            $this->action = 'List Tickets View';
        /** End Log */

        $tickets = $this->repository->index();

        return view('tickets.index',["tickets" => $tickets]);
    }

    public function store(Request $request)
    {
        /** Init log */
            $this->action = 'Store Ticket';
        /** End Log */

        $request->merge(["user_id"=>auth()->user()->id]);

        if (!$request->input('code')){

            $request->merge(["code"=>$request->input('ticket')]);

        }
        return parent::store($request);
    }


    public function report(Request $request)
    {
        return ReportService::report()
            ->setData($this->repository->index())
            ->setTitle("Reporte de Boletos")
            ->setUsername($request->user()->name)
            ->render('tickets');
    }
}
