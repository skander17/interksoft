<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->hasRole(['admin'])){
            $request->merge(['roles'=>[]]);
        }
        /** Init log */
            $this->action = 'store User';
        /** End Log */
        return parent::store($request);
    }

    public function update($id, Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->hasRole(['admin'])){
            $request->merge(['roles'=>[]]);
        }
        /** Init log */
            $this->action = 'update User ' . $id;
        /** End Log */
        return parent::update($id, $request); // TODO: Change the autogenerated stub
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
