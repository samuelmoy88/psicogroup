@props(['id' => ''])
<div class="fade-in fade-out fixed top-5 right-5 md:w-full max-w-sm z-10">
    <input type="checkbox" class="hidden" id="{{ $id }}">

    <label class="close cursor-pointer flex items-start justify-between w-full p-2 bg-green-500 h-24 rounded shadow-lg text-white" title="close" for="{{ $id }}">
        {{ $slot }}
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
    </label>
</div>
<script>
    setTimeout(() => {
        let alert = document.querySelector('#{!! $id !!}');

        if (alert) {
            alert.click();
        }
    }, 2000);

    let el = document.querySelector('#{!! $id !!}');

    el.addEventListener('click', fadeOutEffect);

    function fadeOutEffect() {
        let fadeTarget = document.getElementById("{!! $id !!}");
        let fadeEffect = setInterval(function () {
            if (!fadeTarget.style.opacity) {
                fadeTarget.style.opacity = 1;
            }
            if (fadeTarget.style.opacity > 0) {
                fadeTarget.style.opacity -= 0.1;
                fadeTarget.parentNode.remove();
            } else {
                clearInterval(fadeEffect);
            }
        }, 200);
    }
</script>
