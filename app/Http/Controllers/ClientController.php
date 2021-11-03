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
        'email'     => ['required', 'string', 'email', 'max:255', 'unique:clients'],
        'passport'  => ['required'],
        'passport_exp' => ['required'],
    ];

    protected array $messages = [
            'full_name.required' => "El nombre es requerido",
            'email.required'     => "El email es requerido",
            'email.unique'       => "El email ya se encuentra registrado",
            'passport.required'  => "El pasaporte es requerido",
            'passport_exp.required' => "La fecha de vencimiento del pasaporte es requerida",
        ];

    protected array $alias = [
        "full_name"=>"Nombres",
        "dni"      =>"Dni" ,
        "passport" =>"Pasaporte",
        "email"    => "Correo",
        "passport_exp" => "Vencimiento del pasaporte",
    ];
    protected string $reportTitle = "Reporte de Clientes";

    public function __construct(ClientRepository $repository)
    {
        $this->name = 'client';
        parent::__construct($repository);
    }

    public function index(ClientRepository $repository)
    {
        /** Init log */
            $this->action = 'List Client View';
        /** End Log */
        return view('clients.index', ['clients' => $repository->index()]);
    }

    public function search(Request $request){
        /** Init log */
            $this->action = 'Search Client';
        /** End Log */
        return response()
            ->json($this->repository->search($request->input('search'))->toArray());
    }

    public function store(Request $request)
    {
        /** Init log */
            $this->action = 'Save Client';
        /** End Log */

        if (!$request->has('code')){
            $request->merge(['code'=>$request->input('dni')]);
        }
        return parent::store($request); // TODO: Change the autogenerated stub
    }
}
