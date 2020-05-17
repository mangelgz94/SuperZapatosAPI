<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 7:03 PM
 */

namespace App\Responses\Classes;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class ErrorAPIResponse implements Responsable
{

    protected $errorCode;
    protected static $errorMessages = [
        400 => 'Bad request',
        401 => 'Not authorized',
        404 => 'Record not found',
        500 => 'Server Error',

    ];

    /**
     * ErrorAPIResponse constructor.
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $this->errorCode = Response::HTTP_NOT_FOUND;
        } elseif ($exception instanceof ValidationException) {
            $this->errorCode = Response::HTTP_BAD_REQUEST;
        } elseif ($exception instanceof UnauthorizedException) {
            $this->errorCode = Response::HTTP_UNAUTHORIZED;
        } else {
            $this->errorCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json(['success' => false, 'error_code' => $this->errorCode, 'error_msg' => self::$errorMessages[$this->errorCode]], $this->errorCode);
    }
}