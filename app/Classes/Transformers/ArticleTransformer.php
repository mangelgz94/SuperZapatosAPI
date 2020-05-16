<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 10:09 PM
 */

namespace App\Classes\Transformers;


use App\Article;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{

    public function transform(Article $article)
    {
        return [
            'id'             => $article->id,
            'description'    => $article->description,
            'name'           => $article->name,
            'price'          => $article->price,
            'total_in_shelf' => $article->total_in_shelf,
            'total_in_vault' => $article->total_in_vault,
            'store_name'     => $article->store->name
        ];
    }
}