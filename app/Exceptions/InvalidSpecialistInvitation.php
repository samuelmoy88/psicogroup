<?php

namespace App\Exceptions;

use Exception;

class InvalidSpecialistInvitation extends Exception
{
    public function render()
    {
        return view('exceptions.invalid-specialist-invitation-token');
    }
}
