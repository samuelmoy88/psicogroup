<x-front-layout>
    <div class="main-min-height p-5 grid grid-cols-1 gap-4 mx-auto max-w-6xl lg:grid-cols-6 lg:grid-flow-col-dense">
        <aside class="max-h-96 sticky top-0 bg-gray-200 rounded px-5 py-3 flex flex-col xs:hidden lg:col-span-2 lg:col-start-1" x-data="searchInputs()">
        @include('front.search._side-form')</aside>
        <div class="lg:col-span-4 lg:col-start-3">
        @include('front.search._search-results')</div>
        @push('ads')
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-format="fluid"
                 data-ad-layout-key="-fb+5w+4e-db+86"
                 data-ad-client="ca-pub-1170159379901140"
                 data-ad-slot="4753262210"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        @endpush
    </div>
</x-front-layout>
