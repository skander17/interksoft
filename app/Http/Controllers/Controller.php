<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use App\Services\ReportService;
use App\Models\LogsModule;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $storeRules  = [];
    protected array $updateRules = [];
    protected array $messages    = [];


    protected ?Repository $repository;
    protected ?Request $request;
    private   ?Authenticatable $user;

    protected string $name = "resource";
    protected array  $alias = [];
    protected string $reportTitle = '';
    protected string $action = '';

    private string $time;

    public function __construct(Repository $repository = null, Request $request = null)
    {
        $this->repository = $repository;

        $this->request = $request ?: Request::capture();

        $this->time = microtime(true);

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            return $next($request);
        });
    }


    /**
     * @param $message
     * @param int $code
     * @param array $data
     * @return JsonResponse
     */
    public function jsonResponse($message, $code = 200, $data = []){
        $data['message'] = $message;
        return response()->json($data,$code)->setStatusCode($code,$message);
    }

    /**
     * @param $message
     * @param int $code
     * @param array $data
     * @return JsonResponse|object
     */
    public function errorResponse($message, $code = 500, $data = []){
        $data['message'] = $message;
        $data['error'] = true;
        return response()->json($data,$code)->setStatusCode($code,$message);
    }

    /**
     * @param int $code
     * @param array $data
     * @return JsonResponse|object
     */
    public function unauthorized($code = 403, $data = []){
        $data['message'] = "No posees permisos para realizar ésta acción";
        $data['error'] = true;
        return response()->json($data,$code)->setStatusCode($code,"unauthorized");
    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        if (!$request->user()->can("create " . Str::plural($this->name))){
            return $this->unauthorized();
        }
        $this->validate($request,$this->storeRules,$this->messages);
        $data = $request->all();
        //init Log
         $this->action = 'Store ' . $this->name;
        //
        $resource = $this->repository->store($data);
        return $this->jsonResponse('Recurso creado con éxtio',201,[$this->name=>$resource]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function show($id,Request $request){
        if (!$request->user()->can("show " . Str::plural($this->name))){
            return $this->unauthorized();
        }
        //init Log
        $this->action = 'Show ' . $this->name;
        //
        $resource = $this->repository->show($id);
        return $this->jsonResponse('Encontrado',200,[$this->name=>$resource]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        if (!$request->user()->can("edit " . Str::plural($this->name))){
            return $this->unauthorized();
        }
        //init Log
        $this->action = 'Update ' . $this->name;
        //
        $this->repository->update($id,$request->all());
        return $this->jsonResponse('Registro Editado',200,[$this->name=>$request->all()]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id,Request $request){
        if (!$request->user()->can("delete " . Str::plural($this->name))){
            return $this->unauthorized();
        }
        //init Log
        $this->action = 'Destroy ' . $this->name;
        //
        $this->repository->destroy($id);
        return $this->jsonResponse('Registro Eliminado',206);

    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function report(Request $request){
        $user = $request->user()->name;
        if (count($this->alias) == 0){
            $record = $this->repository->getModel()->newQuery()->first();
            $this->alias =  $record ? array_combine(array_keys($record->toArray()),array_keys($record->toArray())): [];
        }
        return ReportService::report()
                ->setData($this->repository->index()->toArray())
                ->setIndex($this->alias)
                ->setTitle($this->reportTitle)
                ->setUsername($user)
                ->render('automatic');
    }

    public function message($code,$message){
        return response()->json([
            'code' => $code,
            'message' => $message
        ]);
    }


    public function __destruct()
    {
         try {

             if (env('ENABLED_LOG') == 'false'){
                 return;
             }

             LogsModule::create([
                 'module'   => get_called_class(),
                 'action'   => $this->action,
                 'path'     => $this->request->getUri(),
                 'ip'       => $this->request->ip(),
                 'request'  => json_encode($this->request->all()),
                 'headers'  => json_encode($this->request->header()),
                 'username' => $this->user->name,
                 'useremail'=> $this->user->email,
                 'role'=> $this->user->roles[0]->name,
             ]);
         }catch (\Exception $exception){
             Log::critical($exception->getMessage());
         }
    }
}
