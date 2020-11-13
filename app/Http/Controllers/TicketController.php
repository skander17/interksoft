<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected string $name = 'ticket';
    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }

    public function index(Request $request){
        $tickets = $this->repository->index();
        return view('tickets.index',["tickets" => $tickets]);
    }
}
