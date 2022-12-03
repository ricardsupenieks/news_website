<?php

namespace App\Controllers;

use App\Redirect;

class LogoutController
{
    public function logOut(): Redirect {
        session_unset();
        return new Redirect("/");
    }

}