<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/16/2020
 * Time: 7:16 PM
 */

namespace App\Classes\Validators;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class BaseValidator
{

    protected abstract function getCreationRules();

    protected abstract function getUpdateRules();

    /**
     * @param array $data
     * @return bool
     * @throws ValidationException
     */
    public function validateCreation($data)
    {
        $validator = Validator::make($data, $this->getCreationRules());

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
        $validator = Validator::make($data, $this->getUpdateRules());

        if ($validator->fails()) {

            throw new ValidationException($validator);
        }

        return true;
    }
}