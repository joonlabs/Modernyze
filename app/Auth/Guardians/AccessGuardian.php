<?php

namespace App\Auth\Guardians;

use App\Models\Access;
use Curfle\Auth\Guardians\Guardian;
use Curfle\Auth\JWT\JWT;
use Curfle\Http\Request;
use Curfle\Support\Facades\Auth;

class AccessGuardian extends Guardian
{
    /**
     * @inheritDoc
     */
    protected array $supported = [
        Guardian::DRIVER_BEARER
    ];

    /**
     * @inheritDoc
     */
    public function validate(Request $request): bool
    {
        $success = null;

        // validate against bearer authentication
        if ($success === null && $this->supports(self::DRIVER_BEARER)) {
            $token = $request->header("Authorization");
            if ($token !== null) {
                $token = str_replace("Bearer ", "", $token);
                $access = Access::byToken($token);

                // add authenticated user if token is valid
                if ($access !== null) {
                    $success = true;
                    $this->login($access->id);
                }
            }
        }

        return $success ?? false;
    }
}