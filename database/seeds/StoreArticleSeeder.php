<?php

use App\Article;
use App\Store;
use Illuminate\Database\Seeder;

class StoreArticleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = factory(Store::class, 5)->create()->each(function ($store) {
            $articles = factory(Article::class, 10)->make();

            $store->articles()->saveMany($articles);
        });
    }
}
