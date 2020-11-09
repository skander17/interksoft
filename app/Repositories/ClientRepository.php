<?php


namespace App\Repositories;


use App\Models\Client;

class ClientRepository extends Repository
{

    public function __construct(Client $model)
    {
        parent::__construct($model);
    }

}
