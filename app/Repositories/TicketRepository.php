<?php


namespace App\Repositories;



use App\Models\Ticket;

class TicketRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }


}
