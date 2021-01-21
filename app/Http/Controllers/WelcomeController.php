<?php

namespace App\Http\Controllers;

//
use App\Models\User;

class welcomeController extends Controller
{
    /**
     * return info about the resource.
     *
     * @return view
     */
    public function index()
    {
        // pass the number of all registered users to the "welcome" view
        return view('/welcome', ['registeredUsers' => User::count()]);
    }
}
