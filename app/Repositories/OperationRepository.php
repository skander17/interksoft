<?php

namespace App\Repositories;

use App\Models\Operation;

class OperationRepository extends Repository
{
    public function __construct(Operation $model)
    {
        parent::__construct($model);
    }
}
