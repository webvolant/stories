@extends('layouts.app')
@section('content')
    <div>
        <Button>123</Button>
        <Dialog></Dialog>
        <router-link :to="{ name: 'users' }">Login</router-link>
        <router-view></router-view>
    </div>
    <!--<template>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <router-view></router-view>
            </div>
        </div>
    </template>-->
@endsection
