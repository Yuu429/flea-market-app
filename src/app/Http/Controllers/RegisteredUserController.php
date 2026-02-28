<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Http\Controllers\RegisteredUserController as FortifyRegisteredUserController;

class RegisteredUserController extends FortifyRegisteredUserController
{
    public function store(Request $request)
    {
        $user = $this->create($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
