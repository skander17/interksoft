<?php

namespace App\Http\Controllers;

use App\Repositories\TicketsRepository;

class TicketController extends Controller
{
    protected string $name = 'ticket';
    public function __construct(TicketsRepository $repository)
    {
        parent::__construct($repository);
    }
}
