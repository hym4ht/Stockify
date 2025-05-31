<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Show settings form
    public function index()
    {
        $settings = config('app.settings', []);
        return view('admin.settings.index', compact('settings'));
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

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
