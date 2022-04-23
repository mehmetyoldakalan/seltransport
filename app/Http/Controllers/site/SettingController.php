<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings=Setting::first();
        if($settings==NULL||$settings==""){
            $settingArr=[
                'user_id'=>Auth::user()->id
            ];
            Setting::create($settingArr);
        }
        $settingsData=Setting::first();
        return view('site.settings',['settingsData'=>$settingsData]);
    }
    public function update(Request $request)
    {
        if($request->hasFile('top_logo')){
            $ext=$request->file('top_log')->getClientOriginalExtension();
            if($ext=="png"||$ext=="jpg"||$ext=="jpeg"||$ext=="jfif"){
                $top_logo=\Illuminate\Support\Str::random(50).$request->file('top_logo')->getClientOriginalName();
                $request->file('top_logo')->move('storage',$top_logo);
            }else{
                return redirect()->to(route('site/settings'))->with('status','invalid_extensions');
            }
        }else{
            $top_logo=$request->top_logo_back;
        }
        if($request->hasFile('bottom_logo')){
            $ext=$request->file('bottom_logo')->getClientOriginalExtension();
            if($ext=="png"||$ext=="jpg"||$ext=="jpeg"||$ext=="jfif"){
                $bottom_logo=\Illuminate\Support\Str::random(50).$request->file('bottom_logo')->getClientOriginalName();
                $request->file('bottom_logo')->move('storage',$bottom_logo);
            }else{
                return redirect()->to(route('site/settings'))->with('status','invalid_extensions');
            }
        }else{
            $bottom_logo=$request->bottom_logo_back;

        }
        Setting::where('id',$request->id)->update(array_merge($request->except('_token','top_logo_back','bottom_logo_back'),['top_logo'=>$top_logo,'bottom_logo'=>$bottom_logo]));
        return redirect()->to(route('site/settings'))->with('status','success');
    }
}
