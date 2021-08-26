@extends('layouts.app')
@section('title', $item->title)
@section('description', $item->meta_description)
@section('content')
    <div class="container">


        <div class="row mt-3">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                <div class="float-end"><i class="fa fa-youtube-play text-primary" aria-hidden="true"></i> {{$item->views}}</div>
                <div class="clear" style="clear: both"></div>

                <h1 class="text-primary mt-3 mb-4">{{$item->title}}</h1>


                <div class="float-start h5 text-secondary">@foreach($item->authors as $a){{$a->value}}@endforeach</div>
                <div class="float-end h5 text-secondary">{{$item->duration}}</div>

                <div style="margin-top: 5rem">
                    {{$item->meta_description}}
                </div>

                <div class="mt-4">
                    <audio-player :files="{{json_encode($audios)}}" :item="{{$item}}"></audio-player>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                @foreach($item->files as $file)
                    @if($file->type==2)
                        <img src="{{ $file->path }}" style="width: 100%;"/>
                    @endif
                @endforeach


            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                    {!! $item->description !!}
            </div>
        </div>

    </div>
@endsection