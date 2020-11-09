<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    protected array $storeRules = [
        'ful_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:clients'],
        'passport' => ['required'],
        'passport_exp' => ['required'],
    ];

    public function __construct(ClientRepository $repository)
    {
        $this->name = 'client';
        parent::__construct($repository);
    }

    public function index(ClientRepository $repository)
    {
        return view('clients.index', ['clients' => $repository->index()]);
    }
}
