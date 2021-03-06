<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Laravel\Socialite\Facades\Socialite;

//http://192.168.56.101/time/public/index.php/api/items/
//http://192.168.56.101/time/public/index.php/api/auth/callback?code=5b2c030c40f67c6d21d0
/*
 * 1. http://192.168.56.101/time/public/index.php/api/auth/redirect
 * 2. https://github.com/login/oauth/authorize?client_id=7307872ce80ef2ec9eb5&redirect_uri=http%3A%2F%2F192.168.56.101%2Ftime%2Fpublic%2Findex.php%2Fapi%2Fauth%2Fcallback&scope=user%3Aemail&response_type=code
 * get URL
 * get TOken by code url
 * todo: callback url to client and client will get token then will save token.
 */

Route::get('/removeFile', function () {
    //$files = \App\File::all();
    $data = request()->all();
    $id = $data['id'];
    $file = \App\File::find($id);
    File::delete(public_path().$file->path);
    return response()->json(['file'=>$file]);
    //return response()->json(['id'=>$data]);

});

Route::post('/getFiles', function(Request $request) {
    //return response()->json(['files'=>$request->id]);
    $id = $request->id;
    $files = \App\File::whereHas('items', function($q) use  ($id){$q->where('item_id', '=', $id);})->get();
    return response()->json(['files'=>$files]);
});

Route::post('/files', function (Request $request) {
    $data = $request->all();
    $item = \App\Item::find($request->id);
    //return response()->json(['data'=>$data]);
    $filesArr = [];
    $audioTypes = ["mp3", "wav", 'mp4'];
    //$files = $request->file('file');
    if(request()->hasFile('file')){
        $files = request()->file('file');
        foreach ($files as $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('files', $fileName, ['disk' => 'uploads']);
            $filePath = '/uploads/files/'.$fileName;

            $f = new \App\File;
            $f->path = $filePath;
            $f->size = $file->getSize();
            $f->name = $file->getClientOriginalName();
            $f->extension = $file->getClientOriginalExtension();

            if(in_array($f->extension, $audioTypes)){
                $f->type = 1;
            }else{
                $f->type = 2;
            }

            $f->save();
            $filesArr[]=$f;

//image resize
            if($f->type==2){
                $img = Image::make(public_path().$f->path);
                $img->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    //$constraint->upsize();
                });
                $img->save(public_path().$f->path);
            }

            $item->files()->attach($f->id);


            //return response()->json($fileName);
        }
    }
    return response()->json(['files'=>$filesArr]);
});


//get url from api in front
//start url for auth, to get
//http://192.168.56.101/time/public/index.php/api/auth/callback for git settings
Route::post('/countPlay', function () {
    $data = request()->all();

    $item_id = $data['id'];
    $session_id = Session::getId();

    $view = \App\View::where('session_id', $session_id)->where('item_id', $item_id)->whereDate('created_at', '=', date('Y-m-d'))->first();

    if(!empty($view)) return response()->json($view);
    $view = new \App\View;

    $view->item_id = $item_id;
    $view->session_id = $session_id;
    $view->save();

    $item = \App\Item::where('id', $item_id)->first();
    $item->views +=1;
    $item->save();

    return response()->json($view);
});

Route::get('/withauth', function () {
    return response()->json('yes gut response');
})->middleware('auth');

//register new user
/*Route::post('/auth/register', function () {
    $provider = 'github';
    $user = Socialite::driver($provider)->stateless()->user();
    if($user->email){
        //update token
        $u = \App\User::where('provider', $provider)->where('email', $user->email)->first();
        if(empty($u)){
            $newUser = new \App\User();
            $newUser->email = $user->email;
            $newUser->name = $user->name;
            $newUser->provider = $provider;
            $newUser->api_token = $user->token;
            $newUser->save();
            return response()->json([
                'token' => $user->token
            ]);
        }else{
            return response()->json([
                'message' => 'User exist, please sign in',
            ], 404);
        }
    }

    return response()->json([
        'message' => 'Bad credentials',
    ], 401);
});*/

Route::get('/auth/redirect', function () {
    //check if user exist, if not exist mast make register
    $provider = 'github';
    return Socialite::with($provider)->stateless()->redirect()->getTargetUrl();
});

Route::post('/auth/callback', function () {
    $provider = 'github';
    $user = Socialite::driver($provider)->stateless()->user();
    if($user->email){
        //update token
        $u = \App\User::where('provider', $provider)->where('email', $user->email)->first();
        if(!empty($u)){
            $u->api_token = $user->token;
            $u->save();
        }
        //register hier code start
        else{
            $newUser = new \App\User();
            $newUser->email = $user->email;
            $newUser->name = $user->name;
            $newUser->provider = $provider;
            $newUser->api_token = $user->token;
            $newUser->email_verified_at = date('Y-m-d H:m:s');
            $newUser->save();

        }
        //end

        return response()->json([
            'token' => $user->token
        ]);
    }

    return response()->json([
        'message' => 'Bad credentials',
    ], 401);
    //var_dump($user);
});

Route::get('/checkingget', function () {
    //where('name', $key)->
    $authorId = 119;
    $file = \App\File::whereHas('items', function ($q) use ($authorId) {
        $q->where('item_id', $authorId);
    })->firstOrFail();
    dd($file->id);

    // open an image file
    $img = Image::make(public_path()."/uploads/files/1613424698_chenki.jpg");

// resize image instance
    //$img->resize(100,100);

// insert a watermark
    //$img->insert(public_path()."/uploads/files/1613424698_chenki100100.jpg");

    $img->resize(400, 400, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
// save image in desired format
    $img->save(public_path()."/uploads/files/1613424698_chenki100100.jpg");
})->name('checkingget');



Route::post('/item/save', function () {
    $data = request()->all();
    //todo: validation for file
    //return false if >50m file
    //40 files upload same time
    if(empty($data['id'])) {
        $item = new \App\Item;
    }else{
        $item = \App\Item::where('slug',$data['id'])->firstOrFail();
    }
    $item->fill($data);
    $item->user_id = 1;
    $item->save();

    if(!empty($data['authors'])) {
        $arr_authors = [];
        $authors = json_decode($data['authors'], true);
        if(!empty($authors) && count($authors)>0)
            foreach ($authors as $a) {
                $existAuthor = \App\Author::where('value', $a)->first();
                if (!$existAuthor) {
                    $t = new \App\Author;
                    $t->value = $a;
                    $t->save();
                    $arr_authors[] = $t->id;
                }else{
                    $arr_authors[] = $existAuthor->id;
                }
            }
        $item->authors()->sync($arr_authors);
    }

    if(!empty($data['tags'])) {
        $arr_tags = [];
        $tagss = json_decode($data['tags'], true);
        if(!empty($tagss) && count($tagss)>0)
            foreach ($tagss as $tag) {
                $existTag = \App\Tag::where('name', $tag)->first();
                if (!$existTag) {
                    $t = new \App\Tag;
                    $t->name = $tag;
                    $t->save();
                    $arr_tags[] = $t->id;
                }else{
                    $arr_tags[] = $existTag->id;
                }
            }
        $item->tags()->sync($arr_tags);
    }

    $audioTypes = ["mp3", "wav", 'mp4'];

    if(request()->hasFile('files')){
        $files = request()->file('files');
        foreach ($files as $file) {
            //$fileExist = \App\File::where('name', $file->getClientOriginalName())->where('size', $file->getSize())->first();
            //if($fileExist) continue;

            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('files', $fileName, ['disk' => 'uploads']);
            $filePath = '/uploads/files/'.$fileName;

            $f = new \App\File;
            $f->path = $filePath;
            $f->size = $file->getSize();
            $f->name = $file->getClientOriginalName();
            $f->extension = $file->getClientOriginalExtension();

            if(in_array($f->extension, $audioTypes)){
                $f->type = 1;
            }else{
                $f->type = 2;
            }

            $addons = json_decode($data['addons'], true);
            if(!empty($addons[$file->getClientOriginalName()])) $f->title = $addons[$file->getClientOriginalName()];

            if(!empty($data['positions'])){
                $positions = json_decode($data['positions'], true);
                if(!empty($positions[$file->getClientOriginalName()])) $f->position = $positions[$file->getClientOriginalName()];
            }


            //http://time/storage/app/public/uploads/1607613607_Screenshot_126.png
            $f->save();

            //image resize
            if($f->type==2){
                $img = Image::make(public_path().$f->path);
                $img->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    //$constraint->upsize();
                });
                $img->save(public_path().$f->path);
            }

            $item->files()->attach($f->id);
        }
    }

    //extra for edit
    if(!empty($data['addons'])) {
        $addons = json_decode($data['addons'], true);
        if(count($addons)>0) {
            foreach ($addons as $key => $addon) {
                $id = $item->id;
                //$file = \App\File::where('name', $key)->where('files_history.item_id','=',119)->first();
                $file = \App\File::where('name', $key)->whereHas('items', function ($q) use ($id) { $q->where('item_id', $id); })->first();
                if(!empty($file)){
                    $file->title = $addon;
                    $file->save();
                }
            }
        }
    }

    //extra for edit
    if(!empty($data['positions'])) {
        $positions = json_decode($data['positions'], true);
        if(count($positions)>0) {
            foreach ($positions as $key => $posi) {
                $id = $item->id;
                //$file = \App\File::where('name', $key)->where('files_history.item_id','=',119)->first();
                $file = \App\File::where('name', $key)->whereHas('items', function ($q) use ($id) { $q->where('item_id', $id); })->first();
                if(!empty($file)){
                    $file->position = $posi;
                    $file->save();
                }
            }
        }
    }


    //duration block
    $file_audios = \App\File::where('type', 1)->whereHas('items', function($q) use  ($item){$q->where('item_id', '=', $item->id);})->get();
    foreach ($file_audios as $key => $file) {
        $path = public_path().$file->path;
        //$path = public_path().substr($file->path,7);
        //print_r($path); //die();
        $audio = new \App\Libraries\Audio($path);
        //print_r($audio);
        $duration = $audio->getDuration(true);
        //print_r($duration);
        $file->duration = $audio->formatTime($duration);
        $file->duration_original = $duration;
        $file->save();
    }
    $duration = \App\File::where('type', 1)->whereHas('items', function($q) use  ($item){$q->where('item_id', '=', $item->id);})->sum('duration_original');
    $item->duration = gmdate("H:i:s", $duration);
    $item->save();

    $item = \App\Item::where('id', $item->id)->firstOrFail();
    return response()->json(array('item'=>$item));
});

Route::post('/item/file/remove', function () {
    $data = request()->all();
    $f = \App\File::where('name', $data['name'])->where('size', $data['size'])->firstOrFail();

    if(File::exists(public_path().$f->path))
        File::exists(public_path().$f->path);

    $f->items()->detach();
    $f->delete();
    return response()->json($f);
});

//for backend
Route::get('/items/{id}', function ($id) {
    //$item = \App\Item::where('id', $id)->with(["files" => function ($q) {return $q->where('type', '=', 1); }])->with('tags')->firstOrFail();
    $item = \App\Item::where('slug', $id)
        //->with(["files"])
        ->with(["files" => function ($q) {return $q->orderBy('name', 'asc'); }])
        ->with('tags')->with('authors')->firstOrFail();
    //2 = images
    $authors = \App\Author::all()->pluck('value');
    $item->authors->transform(function ($a){
        return $a['value'];
    });
    //$authors = [(object)['id'=>1, 'label'=>'da', 'value'=>'da2']];

    $tags = \App\Tag::all()->pluck('name');
    $item->tags->transform(function ($tag){
        return $tag['name'];
    });
    return response()->json(array('authors'=>$authors,'tags'=>$tags,'item'=>$item));
});//->where('id', '[0-9]+');

//for frontend
Route::get('/item/{id}', function ($id) {
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

    return response()->json(array('tags'=>$tags,'item'=>$item));
});//->cookie('name', 'value');//->where('id', '[0-9]+');


//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::get('/items', function () {
    //die();
    $items = \App\Item::where('id', '>', 0)->where('status', '!=', 2) //ACHTUNG: change that for admin then it will buggig
    ->with(["files" => function ($q) {
        return $q->where('type', '=', 2); //2 = images
    }])
        ->with("tags")
        ->with("authors")
        ->get();
    return response()->json($items);
})->name('items');
//return $request->user();
//});



