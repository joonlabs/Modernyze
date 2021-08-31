<?php

namespace App\Http\Controllers;

use App\Models\User;
use Curfle\Routing\Controller;

class UserController extends Controller
{

    /**
     * Returns all users.
     *
     * @return array
     */
    public function all(): array
    {
        return [
            "users" => User::all()
        ];
    }

    /**
     * Returns one user.
     *
     * @param int $id
     * @return array
     */
    public function get(int $id): array
    {
        return [
            "user" => User::get($id)
        ];
    }
}