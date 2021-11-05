<?php

namespace App\Http\Controllers;

use App\Repositories\OperationRepository;
use Illuminate\Http\Request;

class OperationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @param OperationRepository $operationRepository
     */
    public function __construct(OperationRepository $operationRepository)
    {
        $this->middleware('auth');
        parent::__construct($operationRepository);
    }
}
