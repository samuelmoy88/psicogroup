<x-front-layout>
    <div class="bg-white main-min-height">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="mt-1 text-3xl font-extrabold text-gray-900 sm:text-4xl sm:tracking-tight lg:text-5xl">{{ __('common.inquiry_received') }}</p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">{{ __('common.soon_we_will_reach_you') }}</p>
                <a class="text-blue-500 mt-5" href="{{ route('front.home') }}">{{ __('common.404_copy_go_back') }}</a>
            </div>
        </div>
    </div>
</x-front-layout>
