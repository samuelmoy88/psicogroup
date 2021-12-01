@props(['disabled' => false, 'options' => false, 'placeholder' => '--', 'value' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none']) !!}>
    @if($options)
        @if($placeholder)
        <option value="">{{ __($placeholder) }}</option>
        @endif
        @foreach($options as $option)
            <option value="{{ $option->id }}" {{ $value && $value == $option->id ? 'selected' : '' }}>{{ $option->title }}</option>
        @endforeach
    @endif
</select>
@error($attributes['name'])
<div class="text-red-500 mt-2">{{ $message }}</div>
@enderror
