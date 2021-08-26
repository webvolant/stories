<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class StoryController extends Controller
{

    public function list(){
        return view('story.list');
    }

    public function show(){
        return view('story.form');
    }

    public function edit(){
        $item = Item::find(122);
        return view('story.form', array('item'=>$item));
    }


    public function store(Request $request){
        //print_r(122);
        //dd($request);
        $storeData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);

        if($request->id) { print_r('it is good for edit!'); }

        $item = Item::create($storeData);

        return redirect('/admin/create')->with('completed', 'Student has been saved!');

        //die();
        //return view('story.form');
    }

}
