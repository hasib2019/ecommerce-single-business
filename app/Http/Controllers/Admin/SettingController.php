<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index',compact('settings'));
    }
    public function store(Request $request)
    {
        $keys = $request->except('_token');


        if($request->imageID){
            Setting::set('site_logo', $request->imageID);
        }else{
            foreach ($keys as $key => $value){
                Setting::set($key, $value);
            }
        }

        // Do not write layout-related controls to .env to avoid server restarts.
        // These are now sourced from the Settings table at runtime.

        return redirect('/admin/setting');
    }

    // Left intentionally unused: env mutation is no longer performed for UI toggles.
}
