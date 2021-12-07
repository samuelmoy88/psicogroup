<x-front-layout>
    <div class="relative bg-gray-50">
        <div class="absolute inset-0">
            <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50"></div>
        </div>
        <div class="relative max-w-7xl mx-auto lg:grid lg:grid-cols-5">
            <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                <div class="max-w-lg mx-auto">
                    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        {{ __('common.sales_contact_us') }}
                    </h2>
                    <p class="mt-3 text-lg leading-6 text-gray-500">
                        {{ __('common.sales_contact_us_copy') }}
                    </p>
                    <dl class="mt-8 text-base text-gray-500">
                        {{--<div class="mt-6">
                            <dt class="sr-only">Phone number</dt>
                            <dd class="flex">
                                <!-- Heroicon name: outline/phone -->
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="ml-3">
                                    +1 (555) 123-4567
                                  </span>
                            </dd>
                        </div>--}}
                        <div class="mt-3">
                            <dt class="sr-only">Email</dt>
                            <dd class="flex">
                                <svg class="flex-shrink-0 h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-3">
                                    contacto@psico-group.com
                                  </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                <div class="max-w-lg mx-auto lg:max-w-none">
                    <form action="{{ route('front.pricing-inquiry-store') }}" method="POST" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                        @csrf
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('common.first_name') }}</label>
                            <div class="mt-1">
                                <input  value="{{ old('first_name') }}" type="text" name="first_name" id="first_name" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm focus:border-brand-color focus:border-indigo-500 border-gray-300 rounded-md">
                                @error('first_name')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('common.last_names') }}</label>
                            <div class="mt-1">
                                <input type="text" value="{{ old('last_name') }}" name="last_name" id="last_name" autocomplete="family-name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                @error('last_name')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('common.email') }}</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                @error('email')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('common.phone') }}</label>
                            <div class="mt-1 relative rounded-md">
                                {{--<div class="absolute inset-y-0 left-0 flex items-center">
                                    <label for="country" class="sr-only">Country</label>
                                    <select id="country" name="country" class="h-full py-0 pl-4 pr-8 border-transparent bg-transparent text-gray-500 focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                        <option>US</option>
                                        <option>CA</option>
                                        <option>EU</option>
                                    </select>
                                </div>--}}
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" autocomplete="tel" class="py-3 px-4 block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="+51">
                                @error('phone')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="premium_plan" class="block text-sm font-medium text-gray-700">{{ __('common.premium_plan') }}</label>
                            <div class="mt-1">
                                <select id="premium_plan" name="premium_plan" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    <option value="" class="text-sm font-medium text-gray-700" selected>{{ __('common.choose_a_premium_plan_for_you') }}</option>
                                    @foreach($premiumPlans as $premiumPlan)
                                        <option {{ old('title') == $premiumPlan['title'] ? 'selected' : '' }}
                                            value="{{ $premiumPlan['title'] }}" class="text-sm font-medium text-gray-700"
                                        >{{ $premiumPlan['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('premium_plan')
                                <div class="text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-medium text-gray-700">{{ __('common.message') }}</label>
                            <div class="mt-1">
                                <textarea id="message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md">{{ old('message') }}</textarea>
                            </div>
                            @error('message')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex items-start flex-wrap">
                                <div class="flex-shrink-0">
                                    <input type="hidden" name="user_accepts" value="0">
                                    <x-toggle/>
                                </div>
                                <div class="ml-3">
                                    <p class="text-base text-gray-500">
                                        {{ __('common.by_selecting_agree_policies') }}
                                        <a href="{{ route('front.privacy-policy') }}" class="font-medium text-gray-700 underline">{{ __('common.privacy_policy') }}</a>
                                        <span class="lowercase">{{ __('common.and') }}</span>
                                        <a href="{{ route('front.cookies-policy') }}" class="font-medium text-gray-700 underline">{{ __('common.cookie_policy') }}</a>.
                                    </p>
                                </div>
                                @error('user_accepts')
                                <div class="flex-1-full text-red-500 mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-button type="submit" class="w-full justify-center">
                                {{ __('common.lets_talk') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('button[data-class="toggle-component"]').addEventListener('click', function () {
            let accepts_input = document.querySelector('input[name=user_accepts]');
            if (parseInt(accepts_input.value) === 1) {
                accepts_input.value = 0;
            } else {
                accepts_input.value = 1;
            }
        });
    </script>
</x-front-layout>
