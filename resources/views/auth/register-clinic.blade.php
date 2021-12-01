<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-10 h-10 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register.clinic') }}">
        @csrf

        <!-- First name -->
            <div>
                <x-label for="clinic_name" :value="__('common.clinic_name')" />

                <x-input id="clinic_name" class="block mt-1 w-full" type="text" name="clinic_name" :value="old('clinic_name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Phone number -->
            <div class="mt-4">
                <x-label for="phone" :value="__('common.phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            <!-- Volume -->
            <div class="mt-4">
                <x-label for="volume" :value="__('common.how_many_specialists')" />
                <select name="specialists_volume" id="volume" required class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                    <option>{{ __('common.pick_an_option') }}</option>
                    @foreach($specialistsVolume as $volume)
                        <option value="{{ $volume }}" {{ old('specialists_volume') == $volume ? 'selected' : '' }}>{{ $volume }}</option>
                    @endforeach
                </select>
            </div>
            <!-- City -->
            <div class="mt-4">
                <x-label for="city" :value="__('common.city')" />

                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('common.password')" />

                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('common.confirm_password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('common.already_registered') }}
                </a>

                <x-button class="ml-4">
                    {{ __('common.account_create') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
