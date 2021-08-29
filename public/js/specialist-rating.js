/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./resources/js/specialist-rating.js ***!
  \*******************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var stars = document.querySelectorAll('.fa-star');
var current_rating = document.getElementById('currentRating').dataset.currentRating;
var rating_copy = document.querySelectorAll('.rating-copy');
var was_rating_selected = false;
var steps = 3;
var current_step = 1;
document.getElementById('ratings').addEventListener('mouseleave', function () {
  var _iterator = _createForOfIteratorHelper(stars),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var j = _step.value;

      if (current_rating >= j.dataset.rating && j.classList.contains('empty')) {
        // e.target.classList.toggle('hidden-important')
        j.classList.add('hidden-important');
        document.querySelector("i[data-rating='".concat(j.dataset.rating, "'].filled")).classList.remove('hidden-important');
      }

      if (current_rating < j.dataset.rating && j.classList.contains('filled')) {
        // e.target.classList.toggle('hidden-important')
        j.classList.add('hidden-important');
        document.querySelector("i[data-rating='".concat(j.dataset.rating, "'].empty")).classList.remove('hidden-important');
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  var _iterator2 = _createForOfIteratorHelper(rating_copy),
      _step2;

  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var k = _step2.value;
      k.classList.add('hidden-important');

      if (current_rating === k.dataset.rating) {
        k.classList.remove('hidden-important');
      }
    }
  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }
});

var _iterator3 = _createForOfIteratorHelper(stars),
    _step3;

try {
  for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
    var i = _step3.value;
    i.addEventListener('mouseover', function (e) {
      var rating = e.target.dataset.rating;

      var _iterator5 = _createForOfIteratorHelper(stars),
          _step5;

      try {
        for (_iterator5.s(); !(_step5 = _iterator5.n()).done;) {
          var j = _step5.value;

          if (e.target.matches('.filled') && rating < j.dataset.rating) {
            j.classList.add('hidden-important'); // e.target.classList.add('hidden-important');

            document.querySelector("i[data-rating='".concat(j.dataset.rating, "'].empty")).classList.remove('hidden-important');
          }

          if (e.target.matches('.empty') && rating >= j.dataset.rating) {
            j.classList.add('hidden-important');
            document.querySelector("i[data-rating='".concat(j.dataset.rating, "'].filled")).classList.remove('hidden-important');
          }

          document.querySelector("p[data-rating='".concat(j.dataset.rating, "'].rating-copy")).classList.remove('hidden-important');
          document.querySelector("p[data-rating='".concat(rating, "'].rating-copy")).classList.add('hidden-important');
        }
      } catch (err) {
        _iterator5.e(err);
      } finally {
        _iterator5.f();
      }

      var _iterator6 = _createForOfIteratorHelper(rating_copy),
          _step6;

      try {
        for (_iterator6.s(); !(_step6 = _iterator6.n()).done;) {
          var k = _step6.value;
          k.classList.add('hidden-important');

          if (rating == k.dataset.rating) {
            k.classList.remove('hidden-important');
          }
        }
      } catch (err) {
        _iterator6.e(err);
      } finally {
        _iterator6.f();
      }
    });
    i.addEventListener('click', function (e) {
      current_rating = e.target.dataset.rating;
      document.querySelector('input[name=rating]').value = current_rating;
      was_rating_selected = true;
    });
  }
} catch (err) {
  _iterator3.e(err);
} finally {
  _iterator3.f();
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
    document.querySelectorAll('.negative-copy').forEach(function (item) {
      item.classList.add('hidden');
    });
    document.querySelectorAll('.positive-copy').forEach(function (item) {
      item.classList.add('hidden');
    });

    if (current_rating <= 3) {
      document.querySelectorAll('.negative-copy').forEach(function (item) {
        item.classList.remove('hidden');
      });
      document.querySelector('.positive-remarks').classList.add('order-2');
      document.querySelector('.negative-remarks').classList.add('order-1');
    } else {
      document.querySelectorAll('.positive-copy').forEach(function (item) {
        item.classList.remove('hidden');
      });
      document.querySelector('.positive-remarks').classList.add('order-1');
      document.querySelector('.negative-remarks').classList.add('order-2');
    }
  }
}

var checkboxes = document.querySelectorAll('input[name="feedback_rating[]"]');

var _iterator4 = _createForOfIteratorHelper(checkboxes),
    _step4;

try {
  var _loop = function _loop() {
    var i = _step4.value;
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
  };

  for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
    _loop();
  }
} catch (err) {
  _iterator4.e(err);
} finally {
  _iterator4.f();
}
/******/ })()
;