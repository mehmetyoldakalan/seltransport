<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Language;
use App\Models\site\LanguageConst;
use App\Models\site\LanguageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function index()
    {
        $languageData=Language::all();
        return view('site/LanguageList',['languageData'=>$languageData]);
    }
    public function addLanguage(Request $request)
    {
        $request->validate([
            'language_code'=>"required",
            'language_name'=>"required",
        ]);
        Language::create($request->except("_token"));
        return redirect()->to(route('site/language'));
    }
    public function deleteLanguage($id)
    {
        Language::where('id',$id)->delete();
        return redirect()->to(route('site/language'));
    }
    public function updateLanguageView($id)
    {
        $languageData=Language::where('id',$id)->get();
        return view('site/LanguageUpdate',['languageData'=>$languageData]);
    }
    public function updateLanguage(Request $request,$id)
    {
        if($language=Language::where('id',$id)->update($request->except('_token')))
        {
            return redirect()->to(route('site/language'));
        }
    }
    //language content
    public function getLanguageContent($id)
    {
        $languageConstData=LanguageConst::all();
        return view('site/LanguageContent',['languageConstData'=>$languageConstData,'languageID'=>$id]);
        /*
         $languageConstData=LanguageConst::join('language_contents','language_contents.domain','language_consts.domain')
            ->where('language_contents.domain',Auth::user()->domain)
            ->where('language_contents.language_id',$id)
            ->get();
        return view('site/LanguageContent',['languageConstData'=>$languageConstData,'languageID'=>$id]);
        */
    }
    //--language content--

    //language const
    public function getLanguageConst()
    {
        $constData=LanguageConst::all();
        return view('site/languageConst',['constData'=>$constData]);
    }
    public function addLanguageConst(Request $request)
    {
        LanguageConst::create($request->except('_token'));
        return redirect()->to(route('site/language/const'));
    }
    public function deleteLanguageConst($id)
    {
        LanguageConst::where('id',$id)->delete();
        LanguageContent::where('language_const_id',$id)->delete();
        return redirect()->to(route('site/language/const'));
    }
    //--language const--
    public function addContent(Request $request)
    {
        if($request->has('add')){
            LanguageContent::create($request->except('_token'));
            return back();
        }
        elseif($request->has('update')){
            LanguageContent::where('id',$request->update)->update(['language_variable'=>$request->language_variable]);
            return back();
        }
    }
}
