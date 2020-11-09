<?php


namespace App\Repositories;



use App\Models\Ticket;

class TicketsRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }


}
