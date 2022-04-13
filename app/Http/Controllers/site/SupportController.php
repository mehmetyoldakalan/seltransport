<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $supportData=Support::all();
        return view('site.Support',['supportData'=>$supportData]);
    }
    public function store(Request $request)
    {
        $ip=$request->ip();
        $support_number=mt_rand(10000,99999);
        Support::create(array_merge($request->except('_token'),['ip'=>$ip,'support_number'=>$support_number]));
        return redirect()->to(route('site/support'));
    }
}
