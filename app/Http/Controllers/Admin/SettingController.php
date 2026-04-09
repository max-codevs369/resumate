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
        $settings = Setting::all()->pluck('value', 'key');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        foreach ($inputs as $key => $value) {
            if ($request->hasFile($key)) {
                $setting = Setting::where('key', $key)->first();
                
                if ($setting && $setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }

                $path = $request->file($key)->store('settings', 'public');
                $value = $path;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Semua pengaturan berhasil diperbarui!');
    }
}
