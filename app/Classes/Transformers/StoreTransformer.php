<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/16/2020
 * Time: 7:13 PM
 */

namespace App\Classes\Transformers;


use App\Store;
use League\Fractal\TransformerAbstract;

class StoreTransformer extends TransformerAbstract
{

    public function transform(Store $store)
    {
        return [
            'id'    => $store->id,
            'name'  => $store->name,
            'store' => $store->address
        ];
    }
}