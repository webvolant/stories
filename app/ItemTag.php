<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTag extends Model
{
    protected $table = 'items_tags';
    protected $guarded = ['id'];

    public $timestamps = false;
    //const UPDATED_AT = false;
    //const CREATED_AT = false;
}
