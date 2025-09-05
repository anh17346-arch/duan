<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $formType = $request->input('form_type', 'personal');

        switch ($formType) {
            case 'personal':
                return $this->updatePersonalInfo($request, $user);
            case 'contact':
                return $this->updateContactInfo($request, $user);
            case 'password':
                return $this->updatePassword($request, $user);
            default:
                return back()->with('error', __('app.error') . ': Invalid form type');
        }
    }

    private function updatePersonalInfo(Request $request, $user): RedirectResponse
    {
        $validated = $request->validate([
            'username'     => ['required','min:5','max:20','regex:/^[A-Za-z0-9]+$/', Rule::unique('users','username')->ignore($user->id)],
            'first_name'   => ['required','min:2','max:20','regex:/^\pL+(?:\s\pL+)*$/u'],
            'last_name'    => ['required','min:2','max:20','regex:/^\pL+(?:\s\pL+)*$/u'],
            'gender'       => ['required', Rule::in(['male','female','other'])],
            'address'      => ['required','min:5','max:150','regex:/^[\pL\pN\s,\.\-\/#]+$/u'],
            'avatar'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096','dimensions:min_width=64,min_height=64'],
            'avatar_clear' => ['nullable','boolean'],
        ], [
            'avatar.image' => 'File phải là hình ảnh.',
            'avatar.mimes' => 'Hình ảnh phải có định dạng: jpg, jpeg, png, webp.',
            'avatar.max' => 'Kích thước hình ảnh không được vượt quá 4MB.',
            'avatar.dimensions' => 'Hình ảnh phải có kích thước tối thiểu 64x64 pixel.',
        ]);

        $updates = collect($validated)->except(['avatar', 'avatar_clear'])->toArray();

        // Handle avatar upload/clear
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $updates['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('avatar_clear')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $updates['avatar'] = null;
        }

        $user->forceFill($updates)->save();

        return back()->with('success', __('app.success') . ': ' . __('app.update_personal_info'));
    }

    private function updateContactInfo(Request $request, $user): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'phone' => ['required','regex:/^\d{10,11}$/', Rule::unique('users','phone')->ignore($user->id)],
        ]);

        $user->forceFill($validated)->save();

        return back()->with('success', __('app.success') . ': ' . __('app.update_contact_info'));
    }

    private function updatePassword(Request $request, $user): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required','confirmed','min:8','different:username'],
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['password'])
        ])->save();

        return back()->with('success', __('app.success') . ': ' . __('app.change_password'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required','current_password']]);

        $user = $request->user();

        // Delete avatar file if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', __('app.success') . ': Account deleted successfully.');
    }
}
