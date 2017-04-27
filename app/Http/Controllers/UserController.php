<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'filled',
            'birth_date' => 'date_format:Y-m-d',
            'avatar' => 'url',
        ]);

        $user->fill($request->all());
        $user->save();
        return $user;
    }
}
