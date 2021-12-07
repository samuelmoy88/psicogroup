<x-front-layout>
    <div class="bg-gray-50 max-w-7xl mx-auto py-12 sm:py-24 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-extrabold text-gray-900 sm:text-2xl sm:leading-none sm:tracking-tight lg:text-5xl"
        >{{ __('premium-plans.h1_title') }}</h2>
        <p class="mt-6 max-w-2xl text-xl text-gray-500">{{ __('premium-plans.h1_subtitle') }}</p>
        <div class="mt-24 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
            @foreach($premiumPlans as $premiumPlan)
                <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="absolute top-0 py-1.5 px-4 bg-brand-color rounded-full text-xs font-semibold uppercase tracking-wide text-white transform -translate-y-1/2"
                        >{{ $premiumPlan['title'] }}</h3>
                        <p class="mt-4 flex items-baseline text-gray-900">
                            <span class="text-5xl font-extrabold tracking-tight">S/{{ $premiumPlan['price'] }}</span>
                            @if($premiumPlan['is_yearly'])
                            <span class="ml-1 text-xl font-semibold">{{ __('premium-plans.per_year') }}
                                {{ $premiumPlan['is_monthly'] && $premiumPlan['price'] > 0 ? '*' : '' }}</span>
                            @endif
                        </p>
                        @if($premiumPlan['price'] > 0)
                            <small class="flex-1-full">* S/{{ $premiumPlan['price'] / \App\Services\PaymentFrequency::MONTHLY_COEFFICIENT . ' ' . __('premium-plans.per_month') }}</small>
                        @endif
                        <div class="mt-6 text-gray-500">{!! $premiumPlan['description'] !!}</div>
                        @if($premiumPlan['features'])
                            <ul role="list" class="mt-6 space-y-6">
                            @foreach($premiumPlan['features'] as $features)
                                <li class="grid grid-cols-8">
                                    <svg class="col-span-1 flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="col-span-7 text-gray-500">{{ $features['title'] }}</span>
                                    @if($features['description'])
                                        <div class="flex-1-full col-span-8">
                                            {!! $features['description'] !!}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </div>
                    <a href="{{ route('front.pricing-inquiry-index') }}" class="bg-brand-color text-white hover:bg-indigo-600 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium"
                    >{{ __('common.request_more_info') }}</a>
                </div>
            @endforeach
        </div>
    </div>
</x-front-layout>
