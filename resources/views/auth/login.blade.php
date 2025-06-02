@extends('layouts.guest')

@section('content')
    <div class="w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Welcome back to SHIELA</h1>

        @if ($errors->any())
            <div class="mb-4 text-center text-red-600 text-sm">
                <ul class="list-none p-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <div class="flex justify-between items-center mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="text-center mt-4">
                <span class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">
                        {{ __('Register') }}
                    </a>
                </span>
            </div>
        </form>
    </div>
@endsection
