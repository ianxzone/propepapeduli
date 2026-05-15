<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetupWizardController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.setup.wizard', compact('settings'));
    }

    public function save(Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                $value = $path;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return response()->json(['success' => true, 'message' => 'Konfigurasi berhasil disimpan!']);
    }
}
