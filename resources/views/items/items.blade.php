@extends('layouts.app')
@section('content')
    <div class="row">
    @foreach($items as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-4">
        <div class="card">
            <img src="{{$item->files[0]['path']}}" class="card-img-top" alt="">
            <div class="card-body">
                <a class="text-primary h5" href="{{ url('/books/'.$item->slug) }}">{{$item->title }}</a>
                <p class=""><i class="fa fa-youtube-play text-primary" aria-hidden="true"></i> {{$item->views}}</p>
                <p class="card-text">
                    @foreach($item->authors as $a){{$a->value}}@endforeach
                    <div class="float-end h6 text-secondary">{{$item->duration}}</div>
                </p>
            </div>
        </div>
            </div>
    @endforeach
    </div>
@endsection