<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="login">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('email')" />

                <x-input id="email" class="w-full bg-white rounded border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="w-full bg-white rounded border border-gray-300 focus:border-pink-500 focus:ring-2 focus:ring-pink-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('user.password.request'))
                    <a class="w-full flexunderline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="w-full flex justify-center mt-4">
                    {{ __('Log in') }}
                </x-button>
                {{-- googlelogin--}}
                <div class="w-full flex items-center justify-end mt-4">
                  <a href="{{ ('auth/google') }}">
                    <img src="images/google.png" style="margin-left: 3em;">
                  </a>
                </div>

            </div>
        </form>
        <div id="loading" style="display:none;">
            <div class="loadingMsg"></div>
        </div>
    </x-auth-card>
</x-guest-layout>
 