@extends('layouts.guest')

@section('content')
    <div class="w-full">
        <h1 class="text-2xl font-bold text-center mb-6">Create your SHIELA account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <!-- Submit Button -->
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <span class="text-sm text-gray-600">
                    {{ __('Already registered?') }}
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        {{ __('Login') }}
                    </a>
                </span>
            </div>
        </form>
    </div>
@endsection
