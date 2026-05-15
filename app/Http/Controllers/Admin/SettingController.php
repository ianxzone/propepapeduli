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
        $data = $request->except('_token');
        
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
        return 'general';
    }
}
