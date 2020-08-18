@extends('layouts.index')

@section('head')

    @include('components.home.head')

@endsection

@section('preloader')

    @include('components.home.preloader')
    
@endsection

@section('header')

    @include('partials.sidebar')
    
@endsection

@section('content')

    @include('partials.content')
    
@endsection

@section('js')

    @include('components.home.script')

@endsection