<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', [
            'user' => $user,
            'layout' => $user->isRole('customer') ? 'layout.app' : 'layout.admin',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $validated['profile_photo_path'] = $request->file('photo')->store('profile-photos', 'public');
        }

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        unset($validated['photo']);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
