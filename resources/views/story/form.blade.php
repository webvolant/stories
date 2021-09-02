@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @isset($item)
            <form class="flex flex-col w-full" method="POST" action="{{ route('story.update', $item->id) }}">
                @else
                    <form class="flex flex-col w-full" method="POST" action="{{ route('story.store') }}">
                        @endisset
                        @csrf
                        @isset($item) @method('put') @endisset

                        <input type="hidden" name="id" value="{{isset($item->id) ? $item->id : $id}}"/>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
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

                            <div class="form-group">
                                <label for="name">Slug</label>
                                <input type="text" name="slug" class="form-control @error('title') is-invalid @enderror" value="{{ old('slug', isset($item->slug) ? $item->slug : null) }}"/>
                                @error('slug')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Статус</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="0" selected>Не опубликовано</option>
                                    <option value="1">Опубликовано</option>
                                    <option value="2">Закрыты только файлы</option>
                                </select>
                            </div>

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

                        <div class="title m-b-md">
                            File Uploader - Dropzone
                        </div>
                        <file-uploader :id="{{isset($item->id) ? $item->id : $id}}"></file-uploader>


                        <form>
    </div>
@endsection
