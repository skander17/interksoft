<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class UserController extends Controller
{

    protected array $storeRules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];
    protected array $updateRules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
    ];
    protected array $messages = [
        "email.unique"=>"El correo electronico ya se encuentra registrados"
    ];

    protected string $name = "user";
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function index(UserRepository $repository)
    {
        return view('users.index', ['users' => $repository->getModel()->newQuery()->get()]);
    }

}
