@props(['checked' => false])

<input type="checkbox" {{ $checked ? 'checked' : '' }} {!! $attributes->merge(['class' => 'rounded text-brand-color form-checkbox focus:outline-none dark:focus:shadow-outline-gray']) !!}>
