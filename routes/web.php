<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReController;
use App\Http\Controllers\StoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin/create', [StoryController::class, 'show']);
Route::get('/admin/edit', [StoryController::class, 'edit']);
Route::post('/admin/store', [StoryController::class, 'store'])->name('story.store');
Route::get('/admin/list', [StoryController::class, 'list']);


Route::get('/', function () {
    $items = \App\Item::where('id', '>', 0)->where('status', '!=', 2) //ACHTUNG: change that for admin then it will buggig
    ->with(["files" => function ($q) {
        return $q->where('type', '=', 2); //2 = images
    }])
        ->with("tags")
        ->with("authors")
        ->get();
    return view('items.items', array('items'=>$items));
});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::get('/books', function () {
    //die();
    $items = \App\Item::where('id', '>', 0)->where('status', '!=', 2) //ACHTUNG: change that for admin then it will buggig
    ->with(["files" => function ($q) {
        return $q->where('type', '=', 2); //2 = images
    }])
        ->with("tags")
        ->with("authors")
        ->get();
    return view('items.items', array('items'=>$items));
    //return response()->json($items);
})->name('items');

//for frontend
Route::get('/books/{id}', function ($id) {
    //$session_id = Session::getId();
    //return response()->json(array('id'=>$session_id));
    //$item = \App\Item::where('id', $id)->with(["files" => function ($q) {return $q->where('type', '=', 1); }])->with('tags')->firstOrFail();
    $item = \App\Item::where('slug', $id)
        ->with(["authors"])
        ->with(["files" => function ($q) {return $q->orderBy('position', 'asc'); }])
        ->with('tags')->firstOrFail();
    //2 = images
    $tags = \App\Tag::all()->pluck('name');
    $item->tags->transform(function ($tag){
        return $tag['name'];
    });
    if($item->status == 3) unset($item->files); //close only files
    if($item->status == 2) return response()->json(['message'=>'Bad request'], 404); //close complete

    $item->files->transform(function ($f){
        $f['path'] = '/public'.$f['path'];
        return $f;
    });

    $audios = array();
    foreach($item->files as $file){
        if($file->type == 1){
            $audios[] = $file;
        }
    }

    return view('items.details', array('audios'=>$audios, 'item'=>$item, 'tags'=>$tags));
    //return response()->json(array('tags'=>$tags,'item'=>$item));
});//->cookie('name', 'value');//->where('id', '[0-9]+');



//return $request->user();
//});




/*
Route::get('{any}', function (){
    return view('users.index');
})->where('{any}', '.*');
*/


Route::get('/import-countries', [ReController::class, 'importCountries']); //1
Route::get('/import-cities', [ReController::class, 'importCities']); //2
Route::get('/import-districts', [ReController::class, 'importDistricts']); //3
Route::get('/import-streets', [ReController::class, 'importStreets']); //4
Route::get('/import-items', [ReController::class, 'importItems']); //4



Route::get('/test', function () {
    return 123;
});
