@props(['disabled' => false, 'rows' => 4])

<textarea rows="{{$rows}}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-brand-color focus:border-purple-600 bg-white text-gray-900 appearance-none block w-full rounded-md py-3 px-4 focus:outline-none']) !!}>{{ $slot }}</textarea>
