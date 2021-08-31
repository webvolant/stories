<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\DB;

class StoryController extends Controller
{

    public function index(){
        $items = Item::all();
        return view('story.index', array('items'=>$items));
    }

    public function show(){
        $id=DB::select("SHOW TABLE STATUS LIKE 'items'");
        $next_id=$id[0]->Auto_increment;
        //dd($next_id);
        return view('story.form', array('id'=>$next_id));
    }

    public function edit($id){

        $item = Item::find($id);
        return view('story.form', array('item'=>$item));
    }

    public function update(Request $request, $id){
        $storeData = $request->validate([
            'title' => 'required|max:255',
            //'slug' => 'required|max:255',
        ]);
        Item::whereId($id)->update($storeData);
        return redirect('/admin/edit/'.$id)->with('completed', 'Item has been updated!');
    }

    public function store(Request $request){
        $storeData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        $item = Item::create($storeData);
        return redirect('/admin/create')->with('completed', 'Item has been saved!');
    }

}
