<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(){


{
    $users = User::orderBy('created_at', 'DESC')->paginate(5);
    return view('admin.users.list', ['users' => $users]);
}

    }
    public  function edit($id){


          $user = User::find($id);
          return view('admin.users.edit',['user'=> $user]);
    }
    public function update($id,Request $request){

       $validator = Validator::make($request->all(),[
           'name' => 'required',
           'email' => 'required',
           'designation' =>'required',
           'mobile' => 'required',
        ]);
        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();
       session()->flash('success', 'Users updated successfully!');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request){
       $id = $request->id;
       $user =User::find($id);
       $user->delete();
    }
}
