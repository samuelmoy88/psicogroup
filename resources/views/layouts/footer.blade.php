<!-- This example requires Tailwind CSS v2.0+ -->
<footer class="bg-black w-full">
    <div class="grid sm:grid-cols-3 max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-0">
        <div>
            <a href="/" class="block lg:w-60 xl:w-72">
                <x-logo-white/>
            </a>
        </div>
        <div>
            <div class="flex justify-center space-x-6">
                <a href="https://www.facebook.com/PsiGrp" class="text-gray-400">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="#fff" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="https://www.instagram.com/psicogroup/" class="text-gray-400">
                    <span class="sr-only">Instagram</span>
                    <svg class="h-6 w-6" fill="#fff" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="https://www.linkedin.com/company/psico-group" class="text-gray-400">
                    <span class="sr-only">LinkedIn</span>
                    <img src="{{ asset('images/Raster.png') }}" width="24" height="24" alt="">
                    {{--<svg class="h-6 w-6" fill="#fff" viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" id="fi_1384014">
                        <path d="m256 0c-141.363281 0-256 114.636719-256 256s114.636719 256 256 256 256-114.636719 256-256-114.636719-256-256-256zm-74.390625 387h-62.347656v-187.574219h62.347656zm-31.171875-213.1875h-.40625c-20.921875 0-34.453125-14.402344-34.453125-32.402344 0-18.40625 13.945313-32.410156 35.273437-32.410156 21.328126 0 34.453126 14.003906 34.859376 32.410156 0 18-13.53125 32.402344-35.273438 32.402344zm255.984375 213.1875h-62.339844v-100.347656c0-25.21875-9.027343-42.417969-31.585937-42.417969-17.222656 0-27.480469 11.601563-31.988282 22.800781-1.648437 4.007813-2.050781 9.609375-2.050781 15.214844v104.75h-62.34375s.816407-169.976562 0-187.574219h62.34375v26.558594c8.285157-12.78125 23.109375-30.960937 56.1875-30.960937 41.019531 0 71.777344 26.808593 71.777344 84.421874zm0 0"></path>
                    </svg>--}}
                </a>
            </div>
            <p class="mt-8 text-center text-base text-white">
                &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
            </p>
        </div>
        <nav class="-mx-5 -my-2 flex flex-wrap justify-center flex flex-wrap flex-col items-center text-left" aria-label="Footer">
            <div class="px-5 py-2">
                <a href="{{ route('front.legal-notice') }}" class="text-base text-white">
                    Aviso legal
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('front.cookies-policy') }}" class="text-base text-white">
                    Política de cookies
                </a>
            </div>
            <div class="px-5 py-2">
                <a href="{{ route('front.privacy-policy') }}" class="text-base text-white">
                    Política de privacidad
                </a>
            </div>
            {{--<div class="px-5 py-2">
                <a href="#" class="text-base text-white">
                    Configuración de cookies
                </a>
            </div>--}}
        </nav>
    </div>
</footer>
