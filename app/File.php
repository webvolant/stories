<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    public $timestamps = false;
    //const UPDATED_AT = false;
    //const CREATED_AT = false;

    public function items()
    {
        return $this->belongsToMany(Item::class, 'files_history', 'file_id', 'item_id');
    }
}
