<?php

namespace App\Exceptions;

use Exception;

class InvalidClinicInvitation extends Exception
{
    public function render()
    {
        return view('exceptions.invalid-clinic-invitation-token');
    }
}
