<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{

    use SoftDeletes;

    protected $fillable = ['name', 'address'];

    public function articles()
    {
        return $this->hasMany(Article::class);

    }

}
