<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];

    public function files()
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
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }
}
