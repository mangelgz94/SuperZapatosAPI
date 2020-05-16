<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 6:56 PM
 */

namespace App\Responses\Classes;


use Illuminate\Contracts\Support\Responsable;

class SuccessAPIResponse implements Responsable
{

    protected $modelName;
    protected $data;
    protected $withTotalElements;

    /**
     * APIResponse constructor.
     * @param string $modelName
     * @param  mixed $data
     */
    public function __construct($modelName, $data)
    {
        $this->modelName = $modelName;
        $this->data      = $data;
    }


    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $dataResponse = ['success' => true, $this->modelName => $this->data];
        if (is_array($this->data)) {

            $dataResponse['total_elements'] = count($this->data);
        }

        return response()->json($dataResponse, 200);
    }

}