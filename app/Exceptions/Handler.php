<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * @param $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function errorResponse($message, $code = 500, $data = []){
        $data['message'] = $message;
        $data['error'] = true;
        return response()->json($data,$code)->setStatusCode($code,$message);
    }


    /**
     * @param $messageBag
     * @return array
     */
    public function parseMessageBag($messageBag){
        return array_merge(array_values($messageBag->getMessages()));
    }


    public function render($request, $exception)
    {
        if ($exception instanceof ValidationException) {
             $errors = $this->parseMessageBag($exception->validator->errors());
             if ($request->expectsJson()){
                 return $this->errorResponse("Datos Incorrectos",
                     422,['errors'=>$errors]);
             }
        }

        if (env('APP_DEBUG', false)) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected error. Try later', 500);

    }
}
