<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;
    //const UPDATED_AT = false;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /*public function files()
    {
        return $this->belongsToMany(File::class, 'files_history', 'item_id', 'file_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'items_tags', 'item_id', 'tag_id')->select('name');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'items_authors', 'item_id', 'author_id'); //->select('value')
    }*/
}
