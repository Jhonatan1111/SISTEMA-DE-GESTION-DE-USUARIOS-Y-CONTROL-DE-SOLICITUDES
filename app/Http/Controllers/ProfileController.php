<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        // nombre
        if ($request->user()->isDirty('nombre')) {
            // Handle nombre field changes if needed
        }
        
        // apellido
        if ($request->user()->isDirty('apellido')) {
            // Handle apellido field changes if needed
        }
        
        // celular
        if ($request->user()->isDirty('celular')) {
            // Handle celular field changes if needed
        }
        
        // email
        if ($request->user()->isDirty('email')) {
        }
        
        // role
        if ($request->user()->isDirty('role')) {

        }
        
        // password
        if ($request->user()->isDirty('password')) {
            // Handle password field changes if needed
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
