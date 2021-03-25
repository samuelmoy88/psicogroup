<?php

if (!function_exists('isAllowedTo')) {
    function isAllowedTo(string $action)
    {
        if (!auth()->user()->can($action)) {
            return abort(403, __('common.unauthorized_action'));
        }
    }
}
