<?php

namespace App\Http\Controllers;

use App\Repositories\TicketRepository;

class TicketController extends Controller
{
    protected string $name = 'ticket';
    public function __construct(TicketRepository $repository)
    {
        parent::__construct($repository);
    }
}
