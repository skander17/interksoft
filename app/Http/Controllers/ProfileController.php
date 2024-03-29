<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        /** Init log */
            $this->action = 'List Profile View';
        /** End Log */
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param null $id
     * @param Request|null $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id = null ,Request $request)
    {
        /** Init log */
        $this->action = 'Update User Profile';
        /** End Log */
        auth()->user()->update($request->all());

        return back()->withStatus(__('Perfil editado exitosamente.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        /** Init log */
        $this->action = 'Change User Password ';
        /** End Log */
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withStatusPassword(__('Contraseña editada exitosamente.'));
    }
}
