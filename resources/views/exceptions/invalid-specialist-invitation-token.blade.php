@extends('errors.minimal')

@section('title', __('specialists.invalid_invitation'))
@section('code')
    <div class="bg-white min-h-screen flex flex-col lg:relative">
        <div class="flex-grow flex flex-col">
            <main class="flex-grow flex flex-col bg-white">
                <div class="flex-grow mx-auto max-w-7xl w-full flex flex-col px-4 sm:px-6 lg:px-8">
                    <div class="flex-shrink-0 pt-10 sm:pt-16">
                        <a href="/" class="inline-flex">
                            <img class="h-12 w-auto" src="{{ asset('images/full-horizontal-logo.png') }}" alt="">
                        </a>
                    </div>
                    <div class="flex-shrink-0 py-16 sm:py-16">
                        <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">{{ __('specialists.invalid_invitation_title') }}</h1>
                        <p class="mt-2 text-base text-gray-500">{{ __('specialists.invalid_invitation_subtitle') }}</p>
                        <div class="mt-6">
                            <a href="/" class="text-base font-medium text-indigo-600 hover:text-indigo-500">{{ __('common.404_copy_go_back') }}<span aria-hidden="true"> &rarr;</span></a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
