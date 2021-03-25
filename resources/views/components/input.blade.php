@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none']) !!}>
@error($attributes['name'])
<div class="text-red-500 mt-2">{{ $message }}</div>
@enderror
