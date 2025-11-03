@extends('layouts.app')

@section('title', 'Halaman Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')

    <div class="login-wrapper">
        <h2>Login</h2>

        <form action="/proses-login" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="nama@gmail.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="*" required>
            </div>

            <button type="submit" class="btn btn-masuk">Masuk</button>
        </form>

        <button class="btn btn-google">Google</button>
    </div>

@endsection