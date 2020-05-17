<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/16/2020
 * Time: 7:15 PM
 */

namespace App\Classes\Validators;


class StoreValidator extends BaseValidator
{

    protected function getCreationRules()
    {
        return [
            'name'    => 'required|string',
            'address' => 'required|string'

        ];
    }

    protected function getUpdateRules()
    {
        return [
            'id'      => 'required|string',
            'name'    => 'required|string',
            'address' => 'required|string'
        ];
    }
}