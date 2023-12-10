<x-layouts.app>
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-lg mt-20">
        <h2 class="text-2xl font-bold mb-6">Login</h2>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-red-500">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full py-2 px-3 border rounded placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter your email">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full py-2 px-3 border rounded placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter your password">
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring">{{ __('Log in') }}</button>
            </div>
        </form>
    </div>
</x-layouts.app>
