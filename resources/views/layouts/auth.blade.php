@extends('layouts.index')

@section('head')

    <link rel="stylesheet" href="{{asset('theme/vendors/bundle.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('theme/css/app.css')}}" type="text/css">

@endsection

@section('preloader')

    @include('components.home.preloader')

@endsection

@section('js')

    <script>document.body.classList.add('form-membership');</script>
    <script src="{{asset('theme/vendors/bundle.js')}}"></script>
    <script src="{{asset('theme/js/app.min.js')}}"></script>

@endsection