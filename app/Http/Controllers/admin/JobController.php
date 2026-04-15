<?php

namespace App\Http\Controllers\admin;

use App\Models\Job;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    //
    public function index(){
        $jobs = Job::orderBy('created_at','DESC')->with('user','jobapplications')->paginate(5);

        return view('admin.Job.list',['jobs'=>$jobs]);
    }
    public function edit($id){

         $job = Job::findOrFail($id);
        $categories = Category::get();
        $jobTypes = JobType::get();

        return view('admin.Job.edit',[
            'job'=>$job,
          'categories'=>$categories,
          'jobTypes'=>$jobTypes]
    );
    }
     public function update(Request $request, $id)
    {
        // Handle the store logic here
        // You can use the $request to get the data and save it to the database
        // For example:
        // Job::create($request->all());

        $rules = [
            'title' => 'required',
            'category' => 'required',
            'Jobtype' => 'required',
            'salary' => 'required|numeric|min:0',
            'vacancy' => 'required|integer|min:1',
            'description' => 'required',
            'location' => 'required',
            'company_name' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        //  if ($validator->fails())
        //             return redirect()->back()->withErrors($validator)->withInput();{

        if ($validator->passes()) {
            $job =  Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->Jobtype;
            $job->salary = $request->salary;
            $job->vacancy = $request->vacancy;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->experience = $request->experince;
            $job->responsibilities = $request->responsibility;
            $job->qualifications = $request->qualification;
            $job->keywords = $request->keyword;
            $job->location = $request->location;
            $job->company_name = $request->company_name;
            $job->company_website = $request->company_website;
            $job->company_location = $request->company_location;
            $job->status = $request->status;
            $job->isfeatured = (!empty($request->isfeatured)) ? $request->isfeatured : 0;
            $job->save();

            session()->flash('success', 'Job updated successfully!');
            return response()->json([
                'status' => true,

                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // return view('front.account.job.create');

    }
    public function destroy(Request $request){
          $id = $request->id;
       $job =Job::find($id);
       $job->delete();
    }
}
