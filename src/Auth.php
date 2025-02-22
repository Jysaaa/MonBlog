<?php

namespace App;

use App\Security\ForbiddenException;

class Auth
{

    /**
     * Accès administrateur
     *
     * @throws ForbiddenException
     */
    public static function loginAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['auth']['role'] !== 'admin') {
            throw new ForbiddenException();
        }

        if (!isset($_SESSION['auth'])) {
            throw new ForbiddenException();
        }
    }

    /**
     * Pour lançer session_start
     *
     */
    public static function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


}