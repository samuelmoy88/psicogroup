@props(['selectedMonth' => '', 'selectedYear' => '', 'month' => '', 'year' => '', 'operation' => ''])
<div>
    <div class="flex space-x-2">
        <select name="{{ $month ? $month : 'month' }}"
               class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
            <option value="">{{ __('common.month') }}</option>
            @foreach(monthsOfTheYear() as $month => $label)
                <option value="{{ $month }}" {{ $selectedMonth && $selectedMonth == $month ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <select name="{{ $year ? $year : 'year' }}"
                class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
            <option value="">{{ __('common.year') }}</option>
            @foreach(yearsForDropdown(100, $operation ? $operation : 'subtract') as $year)
                <option value="{{ $year }}" {{ $selectedYear && $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
    </div>
</div>
