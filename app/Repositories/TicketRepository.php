<?php


namespace App\Repositories;



use App\Models\Ticket;

class TicketRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
        return $this->model::with([
            'client','origin_airport','arrival_airport','user','airline','operation'
        ])->get();
    }


}
