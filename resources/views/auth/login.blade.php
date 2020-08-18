@extends('layouts.auth')

@section('content')

    <div class="form-wrapper">
        <h5>Sign in</h5>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                @error('password')
                    <div class="text-danger" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group d-flex justify-content-between">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" checked="" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Remember me</label>
                </div>
                <a href="recovery-password.html">Reset password</a>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Sign in</button>

            <hr>

            <p class="text-muted">Login with your social media account.</p>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-facebook">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-twitter">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-dribbble">
                        <i class="fa fa-dribbble"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-linkedin">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-google">
                        <i class="fa fa-google"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-behance">
                        <i class="fa fa-behance"></i>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#" class="btn btn-floating btn-instagram">
                        <i class="fa fa-instagram"></i>
                    </a>
                </li>
            </ul>

            <hr>

            <p class="text-muted">Don't have an account?</p>

            <a href="{{url('register')}}" class="btn btn-outline-light btn-sm">Register now!</a>
        </form>
    </div>

    @include('components.home.fix')

@endsection