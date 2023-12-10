<x-layouts.app>
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow-lg mt-20">
        <h2 class="text-2xl font-bold mb-6">Register</h2>

                <!-- Session Status -->
                @if (session('status'))
                <div class="mb-4 text-red-500">
                    {{ session('status') }}
                </div>
            @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full py-2 px-3 border rounded placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter your name">
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

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

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full py-2 px-3 border rounded placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500" placeholder="Confirm your password">
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring">{{ __('Register') }}</button>
            </div>
        </form>
    </div>
</x-layouts.app>
