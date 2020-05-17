<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 11:08 PM
 */

namespace App\Classes\Validators;

class ArticleValidator extends BaseValidator
{

    protected function getCreationRules()
    {
        return [
            'name'           => 'required|string',
            'description'    => 'required|string',
            'price'          => 'required|numeric',
            'total_in_shelf' => 'required|numeric',
            'total_in_vault' => 'required|numeric',
            'store_id'       => 'required|numeric'
        ];
    }

    protected function getUpdateRules()
    {
        return [
            'id'             => 'required|numeric',
            'name'           => 'required|string',
            'description'    => 'required|string',
            'price'          => 'required|numeric',
            'total_in_shelf' => 'required|numeric',
            'total_in_vault' => 'required|numeric',
        ];
    }
}