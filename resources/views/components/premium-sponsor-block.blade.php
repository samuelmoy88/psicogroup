@props(['title' => '', 'subtitle' => ''])
<div class="px-3 py-5 bg-gray-50 text-black rounded-md">
    {!! $title ? "<p class='font-extrabold'>$title</p>" : '' !!}
    {!! $subtitle ? "<p class=''>$subtitle</p>" : '' !!}
</div>
