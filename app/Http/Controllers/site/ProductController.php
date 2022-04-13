<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Language;
use App\Models\site\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $languages=Language::all();
        $productData=Product::all();
        return view('site.product',['productData'=>$productData,'languages'=>$languages]);
    }
    public function store(Request $request)
    {

        $product_img0=Str::random(50).$request->file('product_img0')->getClientOriginalName();
        $request->file('product_img0')->move('storage',$product_img0);
        if($request->hasFile('product_img1')){
            $product_img1=Str::random(50).$request->file('product_img1')->getClientOriginalName();
            $request->file('product_img1')->move('storage',$product_img1);
        }else{
            $product_img1=NULL;
        }
        if($request->hasFile('product_img2')){
            $product_img2=Str::random(50).$request->file('product_img2')->getClientOriginalName();
            $request->file('product_img2')->move('storage',$product_img2);
        }else{
            $product_img2=NULL;
        }

        Product::create(array_merge($request->except('_token'), [ "product_img0" => $product_img0,"product_img1"=>$product_img1,'product_img2'=>$product_img2]));
        return redirect()->to(route('site/products'));
    }
    public function updateView($id)
    {
        $productData=Product::where('id',$id)->get();
        return view('site.ProductUpdate',['productData'=>$productData]);
    }
    public function destroy($id){
        Product::where('id',$id)->delete();
        return redirect()->to(route('site/products'))->with('status','success');
    }
    public function update(Request $request)
    {
        if($request->hasFile('product_img0')){
            $ext=$request->file('product_img0')->getClientOriginalExtension();
            if($ext=="png"||$ext=="jpg"||$ext=="jpeg"||$ext=="jfif"){
                $product_img0=Str::random(50).$request->file('product_img0')->getClientOriginalName();
                $request->file('product_img0')->move('storage',$product_img0);
            }else{
                return redirect()->to(route('site/products'))->with('status','invalid_extensions');
            }
        }else{
            $product_img0=$request->product_img0_back;
        }
        if($request->hasFile('product_img1')){
            $ext=$request->file('product_img1')->getClientOriginalExtension();
            if($ext=="png"||$ext=="jpg"||$ext=="jpeg"||$ext=="jfif"){
                $product_img1=Str::random(50).$request->file('product_img1')->getClientOriginalName();
                $request->file('product_img1')->move('storage',$product_img1);
            }else{
                return redirect()->to(route('site/products'))->with('status','invalid_extensions');
            }
        }else{
            $temp=$request->product_img1_back;
            $product_img1=$temp;
        }
        if($request->hasFile('product_img2')){
            $ext=$request->file('product_img2')->getClientOriginalExtension();
            if($ext=="png"||$ext=="jpg"||$ext=="jfif"||$ext=="jpeg"){
                $product_img2=Str::random(50).$request->file('product_img2')->getClientOriginalName();
                $request->file('product_img2')->move('storage',$product_img2);
            }else{
                return redirect()->to(route('site/products'))->with('status','invalid_extensions');
            }
        }else{
            $product_img2=$request->product_img2_back;
        }
        //TODO burası düzenlenecek
        Product::where('id',$request->id)->update([
            'user_id'=>$request->user_id,
            'product_number'=>$request->product_number,
            'product_barcode'=>$request->product_barcode,
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'product_count'=>$request->product_count,
            'product_category'=>$request->product_category,
            'product_notes'=>$request->product_notes,
            'product_img0'=>$product_img0,
            'product_img1'=>$product_img1,
            'product_img2'=>$product_img2,
            'product_status'=>$request->status,
            'product_color'=>$request->product_color
        ]);
        return redirect()->to(route('site/products'));
    }
}
