<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\UserRepository;

class UserController extends Controller
{

    protected array $storeRules = [
        'name'      => ['required', 'string', 'max:255'],
        'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'  => ['required', 'string', 'min:8', 'confirmed'],
    ];
    protected array $updateRules = [
        'name'  => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
    ];
    protected array $messages = [
        "email.unique"  =>    "El correo electronico ya se encuentra registrados"
    ];
    protected array $alias = [
        "name"       =>"Nombres",
        "email"      => "Correo",
        "created_at" => "Fecha de Creacion",
    ];
    protected string $name = "user";

    protected string $reportTitle = "Reporte de Usuarios";

    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function index(UserRepository $repository)
    {
        /** Init log */
            $this->action = 'List Users View';
        /** End Log */

        $roles = Role::all();
        $users = $repository->getModel()->newQuery()->get();
        return view('users.index', ['users' => $users,'roles'=>$roles]);
    }

}
