<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    // Show settings form for Admin
    public function adminSettings()
    {
        $user = auth()->user();
        return view('admin.settings.index', compact('user'));
    }

    // Show settings form for Manager
    public function managerSettings()
    {
        $user = auth()->user();
        return view('manager.settings.index', compact('user'));
    }

    // Show settings form for Staff
    public function staffSettings()
    {
        $user = auth()->user();
        return view('staf.settings.index', compact('user'));
    }

    // Update settings
    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        $messages = [];

        $passwordFields = ['old_password', 'password', 'password_confirmation'];

        $passwordFieldsFilled = collect($passwordFields)->filter(fn ($field) => $request->filled($field))->count();

        // If old_password is filled but other password fields are incomplete
        if ($request->filled('old_password') && $passwordFieldsFilled < 3) {
            // Build custom error message for each empty password field
            $errors = [];
            foreach ($passwordFields as $field) {
                if (!$request->filled($field)) {
                    $errors[$field] = 'Password field is required';
                }
            }
            return back()->withErrors($errors)->withInput();
        }

        if ($passwordFieldsFilled === 3) {
            $rules['old_password'] = 'string';
            $rules['password'] = 'string|min:8|confirmed';
            $rules['password_confirmation'] = 'string';
        }

        $validated = $request->validate($rules, $messages);

        if (!empty($validated['password'])) {
            if (!Hash::check($validated['old_password'], $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect'])->withInput();
            }
            $user->password = bcrypt($validated['password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->save();

        // Redirect back based on user role
        if ($user->role === 'Admin') {
            return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
        } elseif ($user->role === 'Manajer Gudang') {
            return redirect()->route('manager.settings.index')->with('success', 'Settings updated successfully.');
        } elseif ($user->role === 'Staff Gudang') {
            return redirect()->route('staf.settings.index')->with('success', 'Settings updated successfully.');
        } else {
            return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
        }
    }
}
