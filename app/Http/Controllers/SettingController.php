<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('public/logos');
            $validated['logo_path'] = $path;
        }

        // Save settings to config or database as needed
        // For simplicity, assume settings are saved in a file or database

        // Example: save to a JSON file in storage
        Storage::put('settings.json', json_encode($validated));

        // Redirect back based on user role
        $user = auth()->user();
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
