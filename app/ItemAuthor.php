<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemAuthor extends Model
{
    protected $table = 'items_authors';
    protected $guarded = ['id'];

    public $timestamps = false;
    //const UPDATED_AT = false;
    //const CREATED_AT = false;
}
