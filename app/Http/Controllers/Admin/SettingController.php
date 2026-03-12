<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allKeyed();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'contact_email' => 'required|email',
            'resume_path' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Save all text fields
        $fields = ['name', 'tagline', 'bio', 'location', 'contact_email', 'resume_path'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field));
        }

        // Handle avatar upload separately
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            $old = Setting::get('avatar');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            Setting::set('avatar', $path);
        }

        return back()->with('success', 'Settings saved successfully.');
    }
}
