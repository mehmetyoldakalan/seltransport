<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Content;
use App\Models\site\ContentCategory;
use App\Models\site\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index()
    {
        $contentCategory=ContentCategory::all();
        return view('site.contentcategory',['contentCategory'=>$contentCategory]);
    }

    private function imageExtCheck($img)
    {
        $ext=$img->getClientOriginalExtension();
        if($ext=="png"||$ext=="jpeg"||$ext=="jpg"||$ext=="jfif")
            return true;
        else
            return false;

    }
    public function store(Request $request)
    {
        if($request->hasFile('content_img1'))
        {
            if($this->imageExtCheck($request->file('content_img1'))==true)
            {
                $content_img1=Str::random(50).$request->file('content_img1')->getClientOriginalName();
                $request->file('content_img1')->move('storage',$content_img1);
            }
        }else{
            $content_img1=NULL;
        }
        if($request->hasFile('content_img2'))
        {
            if($this->imageExtCheck($request->file('content_img2'))==true)
            {
                $content_img2=Str::random(50).$request->file('content_img2')->getClientOriginalName();
                $request->file('content_img2')->move('storage',$content_img2);
            }
        }else{
            $content_img2=NULL;
        }
        if($request->hasFile('content_img3'))
        {
            if($this->imageExtCheck($request->file('content_img3'))==true)
            {
                $content_img3=Str::random(50).$request->file('content_img3')->getClientOriginalName();
                $request->file('content_img3')->move('storage',$content_img3);
            }
        }else{
            $content_img3=NULL;
        }
        if($request->hasFile('content_img4'))
        {
            if($this->imageExtCheck($request->file('content_img4'))==true)
            {
                $content_img4=Str::random(50).$request->file('content_img4')->getClientOriginalName();
                $request->file('content_img4')->move('storage',$content_img4);
            }
        }else{
            $content_img4=NULL;
        }
        Content::create(array_merge($request->except('_token'),['content_img1'=>$content_img1,'content_img2'=>$content_img2,'content_img3'=>$content_img3,'content_img4'=>$content_img4]));
        return redirect()->to(route('site/content/details',['id'=>$request->content_category_id]));
    }


    public function show($id)
    {
        $contentData=Content::where('content_category_id',$id)->get();
        $languages=Language::all();
        return view('site.contents',['contentData'=>$contentData,'contentCategoryId'=>$id,'languages'=>$languages]);
    }

    public function updateView($id)
    {
        $languages=Language::all();
        $contentData=Content::where('id',$id)->first();
        return view('site.contentupdate',['contentData'=>$contentData,'languages'=>$languages]);
    }
    public function update(Request $request, $id=NULL)
    {
        if($request->hasFile('content_img1')){
            if($this->imageExtCheck($request->file('content_img1'))==true)
            {
                $content_img1=Str::random(50).$request->file('content_img1')->getClientOriginalName();
                $request->file('content_img1')->move('storage',$content_img1);
            }else{
                return redirect()->to(route('site/contents/update/view',['id'=>$request->id]))->with('status','invalid_extension');
            }
        }else{
            $content_img1=$request->content_img1_back;
        }
        if($request->hasFile('content_img2')){
            if($this->imageExtCheck($request->file('content_img2'))==true)
            {
                $content_img2=Str::random(50 ).$request->file('content_img2')->getClientOriginalName();
                $request->file('content_img2')->move('storage',$content_img2);
            }else{
                return redirect()->to(route('site/contents/update/view',['id'=>$request->id]))->with('status','invalid_extension');
            }
        }else{
            $content_img2=$request->content_img2_back;
        }
        if($request->hasFile('content_img3')){
            if($this->imageExtCheck($request->file('content_img3'))==true){
                $content_img3=Str::random(50).$request->file('content_img3')->getClientOriginalName();
                $request->file('storage',$content_img3);
            }else{
                return redirect()->to(route('site/contents/update/view',['id'=>$request->id]))->with('status','invalid_extension');
            }
        }else{
            $content_img3=$request->content_img3_back;
        }
        if($request->hasFile('content_img4')){
            if($this->imageExtCheck($request->file('content_img4'))==true){
                $content_img4=Str::random(50).$request->file('content_img4')->getClientOriginalName();
                $request->file('content_img4')->move('storage',$content_img4);
            }else{
                return redirect()->to(route('site/contents/update/view',['id'=>$request->id]))->with('status','invalid_extension');
            }
        }else{
            $content_img4=$request->content_img4_back;
        }
        Content::where('id',$request->id)
            ->update(array_merge($request->except('_token','content_category_id','content_img1_back','content_img2_back','content_img3_back','content_img4_back'),[
                'content_img1'=>$content_img1,
                'content_img2'=>$content_img2,
                'content_img3'=>$content_img3,
                'content_img4'=>$content_img4
            ]));
        return redirect()->to(route('site/content/details',['id'=>$request->content_category_id]))->with('status','success');
    }
    public function destroy($id)
    {
        Content::where('id',$id)->delete();
        return back()->with('status','success');
    }
    public function addCategory(Request $request)
    {
        ContentCategory::create($request->except('_token'));
        return redirect()->to(route('site/contents'));
    }
    public function deleteCategory($id)
    {
        ContentCategory::where('id',$id)->delete();
        Content::where('content_category_id',$id)->delete();
        return redirect()->to(route('site/contents'));
    }
}
