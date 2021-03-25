@props(['checked' => false])

<input type="radio" {{ $checked ? 'checked' : '' }} {!! $attributes->merge(['class' => 'text-brand-color form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray']) !!}>
