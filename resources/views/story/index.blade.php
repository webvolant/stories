@extends('layouts.app')
@section('content')
    <div class="container">

        <stories-index :route-edit="'{{route('story.edit', '')}}'"></stories-index>
    </div>
@endsection