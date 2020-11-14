<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use App\Services\ReportService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $storeRules = [];
    protected array $updateRules = [];
    protected array $messages = [];
    protected ?Repository $repository;
    protected string $name = "recurso";
    protected array $alias = [];
    protected string $reportTitle = '';

    public function __construct(Repository $repository = null)
    {
        $this->repository = $repository;
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
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request){
        $this->validate($request,$this->storeRules,$this->messages);
        $data = $request->all();
        $resource = $this->repository->store($data);
        return $this->jsonResponse('Recurso creado con éxtio',201,[$this->name=>$resource]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id){
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
        $this->repository->update($id,$request->all());
        return $this->jsonResponse('Registro Editado',200,[$this->name=>$request->all()]);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id){
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
            $record = array_keys($this->repository->getModel()->newQuery()->first()->toArray());
            $this->alias = array_combine($record,$record);
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
}
