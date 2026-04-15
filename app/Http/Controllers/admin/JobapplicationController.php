<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\jobApplication;
use Illuminate\Http\Request;

class JobapplicationController extends Controller
{
    //
    Public function index(){
      $applications =  jobApplication::orderBy('created_at','DESC')
      ->with('job','user','employer')->paginate(5);
      $data['applications'] = $applications;
      return view('admin.JobApplication.list' , $data);
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        Jobapplication::find($id)->delete();
        session()->flash('success', 'Job application deleted successfully.');
        return response()->json(['status' => 'success']);

    }
}
