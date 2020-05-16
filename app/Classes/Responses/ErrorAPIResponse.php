<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 7:03 PM
 */

namespace App\Responses\Classes;


use Illuminate\Contracts\Support\Responsable;

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
     * @param int $errorCode
     */
    public function __construct($errorCode)
    {
        $this->errorCode = $errorCode;
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