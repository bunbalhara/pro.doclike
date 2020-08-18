@extends('layouts.index')

@section('head')

    @include('components.app.head')
    
@endsection

@section('preloader')

    @include('components.app.preloader')
    
@endsection

@section('header')

    @include('components.app.header')

@endsection

@section('footer')

    @include('components.app.footer')

@endsection

@section('js')

    @include('components.app.script')
    
@endsection
