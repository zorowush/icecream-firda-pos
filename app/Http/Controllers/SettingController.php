<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {

            $setting = Setting::create([
                'business_name' => 'Ice Cream Firda',
            ]);

        }

        return view(
            'pos.settings.index',
            compact('setting')
        );
    }

    public function update(Request $request)
    {
        $request->validate([

            'business_name'=>'required',

            'owner_name'=>'nullable',

            'address'=>'nullable',

            'phone'=>'nullable',

            'email'=>'nullable',

            'minimum_stock'=>'required|integer|min:1',

            'tax'=>'required|numeric|min:0',

            'receipt_footer'=>'nullable',

        ]);

        $setting = Setting::first();

        $data = $request->except('logo');

        if($request->hasFile('logo')){

            $data['logo'] = $request
                ->file('logo')
                ->store('settings','public');

        }

        $setting->update($data);

        return back()
            ->with(
                'success',
                'Pengaturan berhasil diperbarui.'
            );
    }
}