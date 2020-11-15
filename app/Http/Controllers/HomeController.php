<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Repositories\TicketRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param TicketRepository $ticketRepository
     * @param ClientRepository $clientRepository
     * @return Application|Factory|View
     */
    public function index(TicketRepository $ticketRepository,ClientRepository $clientRepository)
    {
        $data['total_clients'] = $clientRepository->getModel()::query()->count('id');
        $data['tickets'] = $ticketRepository->getModel()::query()->count('id');
        $data['airport'] = $ticketRepository->getModel()::query()->select('airport_arrival_id',
            DB::raw('COUNT(airport_arrival_id)'))->groupBy('airport_arrival_id')
            ->orderByDesc('count')->first();
        $data['airport'] =  $data['airport'] ? Airport::find($data['airport']->airport_arrival_id)->name : '';
        $data['client'] = $ticketRepository->getModel()::query()->select('client_id',
            DB::raw('COUNT(client_id)'))->groupBy('client_id')
            ->orderByDesc('count')->first();
        $data['client'] =  $data['client'] ? Client::find($data['client']->client_id)->full_name : '';
        return view('dashboard',$data);
    }
}
