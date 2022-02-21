<?php

namespace App\Exceptions;

use App\Http\Controllers\EmailController;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    /*
     */

    const STACK_EXCEPTION = array(
        'Illuminate\Routing\Route',
        'Illuminate\Routing\Router',
        'Illuminate\Pipeline\Pipeline',
        'Illuminate\Foundation\Http\Kernel',
        'Fideloper\Proxy\TrustProxies',
        'Fruitcake\Cors\HandleCors',
        'Illuminate\Foundation\Http\Middleware\ValidatePostSize',
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Foundation\Http\Middleware\TransformsRequest',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Illuminate\Foundation\Http\Middleware\VerifyCsrfToken',
        'Illuminate\Routing\Middleware\SubstituteBindings',
        'Illuminate\Routing\Controller'
    );

    const STACK_DONT_RENDER = array(
        '\Illuminate\Auth\AuthenticationException',
        'Illuminate\Validation\ValidationException',
    );

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($this->isHttpException($exception)) {
            switch($exception->getStatusCode()){
                case 404 :
                    $this->sendMailAdmin($request, $exception, $exception->getStatusCode());
                    return response()->view('errors.' . 'errors404', [], 404);
                    break;
                case 408 :
                    return response()->view('errors.' . 'errors408', [], 408);
                    break;
                case 500 :
                    $this->sendMailAdmin($request, $exception, $exception->getStatusCode());
                    return response()->view('errors.' . 'errors500', [], 500);
                    break;
                case 401 :
                    $this->sendMailAdmin($request, $exception, $exception->getStatusCode());
                    return response()->view('errors.' . 'errors401', [], 401);
                    break;
                default:
                    $this->sendMailAdmin($request, $exception, $exception->getStatusCode());
                    break;
            }
        }else{
            $this->sendMailAdmin($request, $exception);
        }

        foreach(self::STACK_DONT_RENDER as $dontRender){
            if($exception instanceof $dontRender){return parent::render($request, $exception);}
        }

        if(env('APP_DEBUG')){
            return parent::render($request, $exception);
        }else{
            return response()->view('errors.' . 'genericError');
        }
    }

    private function sendMailAdmin($request, $exception, $code = 0){

        foreach(self::STACK_DONT_RENDER as $dontRender){
            if($exception instanceof $dontRender){return;}
        }

        //if(env('APP_PRODUCTION')){
            //$mail = new AppMail();
            $mail = new EmailController();
            $mail->sendMailAdmin($exception, $request, $code, $this::STACK_EXCEPTION, $request->session() ?? array('Out Of Session' => 'Aucune donnée de session'));
            /* $mail->setTransmitter(env('MAIL_FROM_ADDRESS'));
            $mail->setReceiver(env('MAIL_ADMIN'));
            $mail->setSubject(env('APP_NAME') . ' - Error report');
            $mail->setTextMessage(view('Email.ErrorException')
                ->with('exception', $exception)
                ->with('session', $request)
                ->with('code', $code)
                ->with('stackException', $this::STACK_EXCEPTION)
                ->with('sessionApp', isset($request->session()->all()[env('APP_NAME')]) ? $request->session()->all()[env('APP_NAME')] : array('Out Of Session' => 'Aucune donnée de session') )
                ->render());
            $mail->send(); */
        //}
    }
}
