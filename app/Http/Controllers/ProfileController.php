<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(): View
    {
        return view('dashboard.profile.index');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(): View
    {
        return view('dashboard.profile.edit');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        try {
            $imageName = $user->image;

            if ($request->hasFile('image')) {
                // Handle image upload
                $image = $request->file('image');

                // Delete old image if exists
                if ($user->image) {
                    Storage::delete('public/images/users/' . $user->image);
                }

                // Generate new image name
                $imageName = $user->name . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Store new image
                $image->storeAs('public/images/users/', $imageName);
            }

            // Update user data
            $user->update([
                'name' => $validatedData['name'],
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'image' => $imageName,
            ]);

            return Redirect::route('profile.index')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return Redirect::route('profile.index')
                ->with('status', 'profile-update-failed')
                ->with('error', $e->getMessage());
        }
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
