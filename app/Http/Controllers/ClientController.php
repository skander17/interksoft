<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use FontLib\Table\Type\name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    protected array $storeRules = [
        'full_name' => ['required', 'string', 'max:255'],
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

    public function search(Request $request){
        return response()
            ->json($this->repository->search($request->input('search'))->toArray());
    }
}
