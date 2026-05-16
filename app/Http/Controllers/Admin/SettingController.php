<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:100',
            'site_description' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:png,ico,svg|max:1024',
            'enable_rate_limiting' => 'nullable|boolean',
            'enable_security_headers' => 'nullable|boolean',
            'enable_captcha' => 'nullable|boolean',
            'max_login_attempts' => 'nullable|integer|min:1|max:20',
        ]);

        $data = $request->except('_token');
        
        // Handle checkboxes for booleans
        $data['enable_rate_limiting'] = $request->has('enable_rate_limiting') ? '1' : '0';
        $data['enable_security_headers'] = $request->has('enable_security_headers') ? '1' : '0';
        $data['enable_captcha'] = $request->has('enable_captcha') ? '1' : '0';

        // Handle Logo Upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('branding', 'public');
            $data['site_logo'] = '/storage/' . $path;
        }

        // Handle Favicon Upload
        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('branding', 'public');
            $data['site_favicon'] = '/storage/' . $path;
        }

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $this->getGroupForKey($key)]
            );
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    private function getGroupForKey($key)
    {
        if (in_array($key, ['site_name', 'site_description', 'site_logo', 'site_favicon'])) {
            return 'branding';
        }
        if (in_array($key, ['timezone', 'locale'])) {
            return 'localization';
        }
        if (in_array($key, ['enable_rate_limiting', 'enable_security_headers', 'enable_captcha', 'max_login_attempts'])) {
            return 'security';
        }
        return 'general';
    }
}
