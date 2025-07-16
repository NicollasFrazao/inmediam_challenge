<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return User::find(1);
    }

    public function contract()
    {
        if ($user = User::find(1)) return $user->current_contract;
    }
}
