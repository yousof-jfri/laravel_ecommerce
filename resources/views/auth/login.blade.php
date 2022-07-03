@extends('layouts.auth')

@section('title', 'صفحه ورود')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">ایمیل</label>
            <br>
            <input type="text" id="email" name="email" class="text-input" placeholder="لطفا ایمیل خود را وارد کنید" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">رمز ورود</label>
            <br>
            <input type="password" id="password" name="password" class="text-input" placeholder="لطفا رمز ورود خود را وارد کنید" required autocomplete="current-password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="remember">
                {{ __('مرا به خاطر داشته باش') }}
            </label>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        </div>

        <div class="form-group">
            <button type="submit" class="btn button-orange">ورود</button>
            <button type="button" class="btn button-red">
                <i class="fab fa-google"></i>
                <span>ورود با گوگل</span>
            </button>
            <a href="{{ route('register') }}">ساخت اکانت جدید</a>
        </div>
    </form>
@endsection
