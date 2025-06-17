<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    /**
     * Handle user registration request.
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', Rule::in(['Admin', 'Staff Gudang', 'Manajer Gudang'])],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors();
            if ($errors->has('password') && in_array('The password confirmation does not match.', $errors->get('password'))) {
                return Redirect::back()
                    ->withInput()
                    ->with('error', 'Password and Confirm Password do not match.');
            }
            throw $e;
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Optionally, log the user in after registration
        // Auth::login($user);

        return Redirect::route('login')->with('success', 'Registration successful. Please login.');
    }

    /**
     * Handle user login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

if (Auth::attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    $user = Auth::user();
    if ($user->role === 'Admin') {
        return Redirect::intended('/admin/dashboard');
    } elseif ($user->role === 'Manajer Gudang') {
        return Redirect::intended('/manager/dashboard');
    }

    return Redirect::intended('/dashboard'); // Adjust redirect as needed
}

        return Redirect::back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->with('error', 'Email atau password tidak sesuai.')
            ->onlyInput('email');
    }

    /**
     * Handle user logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::route('login');
    }
}
