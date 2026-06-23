<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar formulario de perfil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar datos del perfil (nombre / email) o contraseña si se pide.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 🟣 Si el formulario viene del MODAL de cambio de contraseña
        if ($request->boolean('change_password')) {

            // 1) Validar sólo campos de contraseña
            $request->validate([
                'current_password'     => ['required'],
                'password'             => ['required', 'min:6', 'confirmed'],
            ]);

            // 2) Verificar contraseña actual
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->with('error_password', 'La contraseña actual no es correcta.');
            }

            // 3) Cambiar contraseña
            $user->password = $request->password;
            $user->save();

            return Redirect::route('profile.edit')
                ->with('status', 'password-updated');
        }

        // 🟢 Si NO viene del modal, es una actualización normal de perfil
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Eliminar la cuenta del usuario.
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
