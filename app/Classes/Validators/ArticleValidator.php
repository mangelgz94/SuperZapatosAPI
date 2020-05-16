<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 11:08 PM
 */

namespace App\Classes\Validators;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ArticleValidator
{

    protected static $creationRules = [
        'name'           => 'required|string',
        'description'    => 'required|string',
        'price'          => 'required|numeric',
        'total_in_shelf' => 'required|numeric',
        'total_in_vault' => 'required|numeric',
        'store_id'       => 'required|numeric'
    ];

    protected static $updateRules = [
        'id'             => 'required|numeric',
        'name'           => 'required|string',
        'description'    => 'required|string',
        'price'          => 'required|numeric',
        'total_in_shelf' => 'required|numeric',
        'total_in_vault' => 'required|numeric',
    ];

    /**
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function validateCreation($data)
    {
        $validator = Validator::make($data, self::$creationRules);

        if ($validator->fails()) {

            throw new ValidationException($validator);
        }

        return true;
    }

    /**
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function validateUpdate($data)
    {
        $validator = Validator::make($data, self::$updateRules);

        if ($validator->fails()) {

            throw new ValidationException($validator);
        }

        return true;
    }

}