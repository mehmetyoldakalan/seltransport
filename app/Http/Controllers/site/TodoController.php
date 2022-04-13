<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\site\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        try {
            Todo::create(array_merge($request->except('_token'),['ip'=>$request->ip()]));
            return redirect()->to(route('site/homePage'))->with('status','success');
        }
        catch (\Exception $e)
        {
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
    }
    private function checkTodo($id):bool
    {
        $check=Todo::where('id',$id)->all();
        if(count($check)==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function destroy($id)
    {
        try{
            if($this->checkTodo($id)==true)
            {
                todo::where('id',$id)->delete();
                return redirect()->to(route('site/homePage'))->with('status','success');
            }
        }
        catch (\Exception $e)
        {
            Log::alert('An error occurred while trying to delete todo | error ->'.$e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }
    public function update(Request $request,$id)
    {
        if($this->checkTodo($id)==true)
        {
            try{
                Todo::where('id',$id)->update(array_merge($request->except('_token'),['ip'=>$request->ip()]));
                return redirect()->to(route('site/homePage'))->with('status','success');
            }catch (\Exception $e){
                Log::alert('An error occurred while trying to update todo  error ->'.$e->getMessage());
                return back()->withErrors(['error',$e->getMessage()]);
            }
        }
    }
    public function changeMood($id)
    {
        Todo::where('id',$id)->update(['todo_status'=>'deactive']);
        return redirect()->to(route('site/homePage'))->with('status','success');
    }
}
