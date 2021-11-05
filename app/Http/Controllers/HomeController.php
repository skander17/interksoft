<?php

namespace App\Http\Controllers;

use App\Repositories\AirportRepository;
use App\Repositories\ClientRepository;
use App\Repositories\TicketRepository;
use App\Services\TicketService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->middleware('auth');
        parent::__construct($ticketRepository);
    }

    /**
     * Show the application dashboard.
     *
     * @param TicketService $ticketService
     * @param ClientRepository $clientRepository
     * @param AirportRepository $airportRepository
     * @return Application|Factory|View
     */
    public function index(TicketService $ticketService,ClientRepository $clientRepository, AirportRepository $airportRepository)
    {
        //init Log
            $this->action = 'List Dashboard';
        //
        $data['total_clients'] = $clientRepository->getModel()::query()->count('id');

        $data['weekly_sales']  = $ticketService->getCountedLatestTickets();

        $data['tickets'] = $ticketService->getRepository()->getTotalOfTickets();

        $most_visited    = $ticketService->getMostVisitedAirport();

        $data['airport'] =  $most_visited ? $airportRepository->getModel()::find($most_visited['airport_arrival_id'])->name : '';

        $most_frequent   = $ticketService->getMostFrequentClient();

        $data['client']  =  $most_frequent ? $clientRepository->getModel()::find($most_frequent['client_id'])->full_name : '';


        //return response()->json($data);
        return view('dashboard',$data);
    }
}
