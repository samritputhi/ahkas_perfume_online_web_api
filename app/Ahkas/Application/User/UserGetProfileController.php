<?php

namespace App\Ahkas\Application\User;

use Illuminate\Http\Request;

/**
 * @author SOPHEAK
 */
class UserGetProfileController
{

    public function __invoke(Request $request)
    {
        $user = $request->user();

        return $user;
    }
}
