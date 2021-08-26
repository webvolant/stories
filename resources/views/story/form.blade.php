@extends('layouts.app')
@section('content')
    <div class="container">
        @isset($item)
            <form class="flex flex-col w-full" method="POST" action="{{ route('story.store', $item->id) }}">
        @else
            <form class="flex flex-col w-full" method="POST" action="{{ route('story.store') }}">
        @endisset
            @csrf
            <div class="flex w-full">
                <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', isset($item->title) ? $item->title : null) }}"/>
                    @error('title') {{-- @if ($errors->has('name')) --}}
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @enderror
                </div>

                {{--<div class="form-group">
                    <label for="name">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $item->slug) }}"/>
                </div>--}}

                {{-- form input element
                <div class="flex flex-wrap">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                    <input id="name" type="text" required name="name" value="{{ old('title', $item->title) }}" class="@error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                    @enderror
                </div>
                --}}
            </div>
            <button type="submit">Сохранить</button>
            <form>
    </div>
@endsection