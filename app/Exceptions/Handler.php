<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Http\Responses\Response;
//Test log
use App\utils\LogHelper; 

 

class Handler extends ExceptionHandler
{
    //publlic $oResult;
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Return a JSON response with the response array and status code
         $rendered = parent::render($request, $e);
        
         //tomar la URi de request del objeto request
        $request_uri = explode("/",$request);

        switch($request_uri[3])
         {
             case "academia":
                     LogHelper::LogExceptionSave(env('ACADEMIA_SYSTEM_ID'),response()->json(['error' => ['code' => $rendered->getStatusCode(),'message' => $e->getMessage(),]]));
                break;
            case 'emprende':
                     LogHelper::LogExceptionSave(env('EMPRENDE_SYSTEM_ID'),response()->json(['error' => ['code' => $rendered->getStatusCode(),'message' => $e->getMessage(),]]));
                break;
         }
        
        /*return response()->json([
            'error' => [
                'code' => $rendered->getStatusCode(),
                'message' => $e->getMessage(),
            ]
        ]);*/
        return parent::render($request, $e);
    }
}
