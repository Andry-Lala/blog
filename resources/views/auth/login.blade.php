@extends('layouts.auth')

@section('title', __('messages.login'))

@section('subtitle', __('messages.connect_to_account'))

@section('content')
    <div class="bg-white shadow rounded-lg p-8 max-w-md mx-auto">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Username/Email -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-600">
                    {{ __('messages.username_or_email') }}
                </label>
                <div class="mt-1">
                    <input id="username" name="username" type="text" autocomplete="username" required
                        value="{{ old('username') }}"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-400 focus:border-blue-400 sm:text-sm">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">
                    {{ __('messages.password') }}
                </label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-400 focus:border-blue-400 sm:text-sm">
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-800">
                        {{ __('messages.remember_me') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-blue-500 hover:text-blue-600">
                            {{ __('messages.forgot_password') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-400 group-hover:text-blue-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    {{ __('messages.sign_in') }}
                </button>
            </div>

            <!-- Register link -->
            <div class="text-center">
                <span class="text-sm text-gray-500">
                    {{ __('messages.no_account_yet') }}
                    <a href="{{ route('register') }}"
                        class="font-medium text-blue-500 hover:text-blue-600">
                        {{ __('messages.register') }}
                    </a>
                </span>
            </div>
        </form>
    </div>
@endsection
