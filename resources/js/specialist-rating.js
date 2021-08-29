let stars = document.querySelectorAll('.fa-star');
let current_rating = document.getElementById('currentRating').dataset.currentRating;
let rating_copy = document.querySelectorAll('.rating-copy');
let was_rating_selected = false;
let steps = 3;
let current_step = 1;

document.getElementById('ratings').addEventListener('mouseleave',function () {
    for (let j of stars) {
        if (current_rating >= j.dataset.rating && j.classList.contains('empty')) {
            // e.target.classList.toggle('hidden-important')
            j.classList.add('hidden-important');
            document.querySelector(`i[data-rating='${j.dataset.rating}'].filled`).classList.remove('hidden-important');
        }
        if (current_rating < j.dataset.rating && j.classList.contains('filled')) {
            // e.target.classList.toggle('hidden-important')
            j.classList.add('hidden-important');
            document.querySelector(`i[data-rating='${j.dataset.rating}'].empty`).classList.remove('hidden-important');
        }
    }

    for (let k of rating_copy) {
        k.classList.add('hidden-important');

        if (current_rating === k.dataset.rating) {
            k.classList.remove('hidden-important');
        }
    }
});

for (let i of stars) {
    i.addEventListener('mouseover', function (e) {
        let rating = e.target.dataset.rating;
        for (let j of stars) {
            if (e.target.matches('.filled') && rating < j.dataset.rating) {
                j.classList.add('hidden-important');
                // e.target.classList.add('hidden-important');
                document.querySelector(`i[data-rating='${j.dataset.rating}'].empty`).classList.remove('hidden-important');
            }
            if (e.target.matches('.empty') && rating >= j.dataset.rating) {

                j.classList.add('hidden-important');
                document.querySelector(`i[data-rating='${j.dataset.rating}'].filled`).classList.remove('hidden-important');
            }
            document.querySelector(`p[data-rating='${j.dataset.rating}'].rating-copy`).classList.remove('hidden-important');
            document.querySelector(`p[data-rating='${rating}'].rating-copy`).classList.add('hidden-important');
        }

        for (let k of rating_copy) {
            k.classList.add('hidden-important');

            if (rating == k.dataset.rating) {
                k.classList.remove('hidden-important');
            }
        }
    });
    i.addEventListener('click', function (e) {
        current_rating = e.target.dataset.rating;
        document.querySelector('input[name=rating]').value = current_rating;
        was_rating_selected = true;
    })
}
document.querySelector('.previous').addEventListener('click', function () {
    current_step--;
    if (current_step === 1) {
        document.getElementById('rating').classList.remove('hidden');
        document.getElementById('rating-feedback').classList.add('hidden');
        document.querySelector('.previous').classList.add('hidden');
    }
    if (current_step === 2) {
        document.getElementById('rating').classList.add('hidden');
        document.getElementById('rating-feedback').classList.remove('hidden');
    }

    document.querySelector('.submit-rating').classList.add('hidden');
    document.querySelector('#remarks').classList.add('hidden');
    document.querySelector('.next').classList.remove('hidden');
});

document.querySelector('.next').addEventListener('click', function () {
    current_step++;

    if (current_step === 2) {
        document.getElementById('rating-feedback').classList.remove('hidden');
    }

    if (current_step === 3) {
        document.getElementById('rating-feedback').classList.add('hidden');
    }

    document.getElementById('rating').classList.add('hidden');
    document.querySelector('.previous').classList.toggle('hidden');
    toggleRatingFeedback();
    showSubmit();
});

function showSubmit() {
    if (current_step === steps) {
        document.querySelector('#remarks').classList.remove('hidden');
        document.querySelector('#rating').classList.add('hidden');
        document.querySelector('#rating-feedback').classList.add('hidden');
        document.querySelector('.submit-rating').classList.remove('hidden');
        document.querySelector('.next').classList.add('hidden');
        document.querySelector('.previous').classList.toggle('hidden');
    }
}

function toggleRatingFeedback() {
    if (current_step === 2) {
        document.querySelector('.positive-remarks').classList.remove('order-1', 'order-2');
        document.querySelector('.negative-remarks').classList.remove('order-1', 'order-2');
        document.querySelectorAll('.negative-copy').forEach(item => {
            item.classList.add('hidden');
        });
        document.querySelectorAll('.positive-copy').forEach(item => {
            item.classList.add('hidden');
        });

        if (current_rating <= 3) {
            document.querySelectorAll('.negative-copy').forEach(item => {
                item.classList.remove('hidden');
            });
            document.querySelector('.positive-remarks').classList.add('order-2');
            document.querySelector('.negative-remarks').classList.add('order-1');
        } else {
            document.querySelectorAll('.positive-copy').forEach(item => {
                item.classList.remove('hidden');
            });
            document.querySelector('.positive-remarks').classList.add('order-1');
            document.querySelector('.negative-remarks').classList.add('order-2');
        }
    }
}

let checkboxes = document.querySelectorAll('input[name="feedback_rating[]"]');

for (let i of checkboxes) {
    i.addEventListener('change', function () {
        if (i.checked) {
            i.nextElementSibling.classList.add('text-brand-color', 'font-bold');
            i.nextElementSibling.nextElementSibling.classList.add('bg-brand-color-alpha');
            i.nextElementSibling.nextElementSibling.classList.remove('border-transparent', 'text-white');
        } else {
            i.nextElementSibling.classList.remove('text-brand-color', 'font-bold');
            i.nextElementSibling.nextElementSibling.classList.add('border-brand-color', 'text-white');
            i.nextElementSibling.nextElementSibling.classList.remove('bg-brand-color-alpha', 'text-white');
        }
    });
}
