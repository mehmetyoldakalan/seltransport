<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Gallery;
use App\Models\site\Language;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $languages=Language::all();
        $gallery=Gallery::all();
        return view('site/Gallery',['languages'=>$languages,'gallery'=>$gallery]);
    }
    public function store(Request $request)
    {
        $gallery=new Gallery();
        if($request->hasFile('image')){
            $ext=$request->file('image')->getClientOriginalExtension();
            $size=$request->file('image')->getSize();
            if($size>100000){
                return redirect()->to(route('site/gallery'))->with('status','invalid_extension');
            }
            //TODO bu kısım düzenlenecek
            if($ext=="png"||$ext=="jpg"||$ext=="jpeg"||$ext=="jfif"){
                $file_name=Str::random(50).$request->file('image')->getClientOriginalName();
                $request->file('image')->move('storage',$file_name);
                $gallery->user_id=Auth::user()->id;
                $gallery->language_id=$request->language_id;
                $gallery->image_title=$request->image_title;
                $gallery->image=$file_name;
                $gallery->category=$request->category;
                $gallery->ordercount=$request->order;
                $gallery->status="active";
                if($gallery->save()){
                    return redirect()->to(route('site/gallery'))->with('status','success');
                }else{
                    return back()->with('status','error');
                }
            }else{
                return redirect()->to(route('site/gallery'))->with('status','invalid_extension');
            }
        }else{
            return redirect()->to(route('site/gallery'))->with('status','empty_file');
        }
    }
    public function destroy($id)
    {
        Gallery::where('id',$id)->delete();
        return redirect()->to(route('site/gallery'))->with('status','success');
    }
    public function switch_status($id)
    {
        $status=Gallery::where('id',$id)->get('status');
        if($status[0]['status']=='active')
        {
            Gallery::where('id',$id)->update(['status'=>'deactive']);
        }
        elseif($status[0]['status']=='deactive')
        {
            Gallery::where('id',$id)->update(['status'=>'active']);
        }
        return redirect()->to(route('site/gallery'))->with('status','success');
    }
}
