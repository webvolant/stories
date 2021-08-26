<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;
    //const UPDATED_AT = false;
    //const CREATED_AT = false;

    protected $hidden = ['pivot'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
