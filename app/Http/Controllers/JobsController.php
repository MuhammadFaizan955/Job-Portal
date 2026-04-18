<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use App\Models\SavedJob;
use Illuminate\Http\Request;
use App\Models\jobApplication;
use App\Mail\JobNotificationEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         $categories = Category::where('status', 1)->get();
          $jobtypes = JobType::where('status', 1)->get();
           $jobs = Job::where('status',1);
           // Search Using kywords
          if (!empty($request->keywords)) {
    $jobs = $jobs->where(function ($query) use ($request) {
        $query->orWhere('title', 'like', '%' . $request->keywords . '%');
        $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');
    });
}

           //Search using location
             if (!empty($request->location)) {
                $jobs= $jobs->where('location',$request->location);
             }
           //Seach using  category
            if (!empty($request->category)) {
                $jobs= $jobs->where('category_id',$request->category);
             }
             // Searching Using Job Type
             $jobtypesArray = [];
              if (!empty($request->jobtype)) {
                // if the user select multiple job types
                $jobtypesArray = explode(',',$request->jobtype);
                $jobs= $jobs->whereIn('job_type_id',$jobtypesArray);
             }
             // Searching Using Experience
              if (!empty($request->experience)) {
                $jobs= $jobs->where('experience',$request->experience);
             }
             //sort
             if (($request->sort == 0)) {
                 $jobs = $jobs->orderBy('created_at','ASC');
             } else {
                 $jobs = $jobs->orderBy('created_at', 'DESC');
             }

        $jobs = $jobs->with('JobType');
        $jobs = $jobs->orderBy('created_at','DESC');
        $jobs = $jobs->paginate(5);

          $data['categories'] = $categories;
          $data['jobtypes'] =$jobtypes;
          $data['jobs'] =$jobs;
          $data['jobtypesArray'] = $jobtypesArray;
        return view('front.job',$data);
    }

    public function saveJob(Request $request)
    {
        //
        $id = $request->id;
        $job = Job::where('id',$id)->first();
        if ($job == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ]);
        }
        // Here you can add logic to save the job for the user, e.g., save to database
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        if ($count > 0) {
            session()->flash('error', 'You have already saved this job');
            return response()->json([
                'status' => false,
                'message' => 'You have already saved this job'
            ]);
        }
        $savedjobs = new SavedJob();
        $savedjobs->user_id = Auth::user()->id;
        $savedjobs->job_id = $id;
        // $savedjobs->saved_at = now();
        $savedjobs->save();
        session()->flash('success', 'Job saved successfully');
        return response()->json([
            'status' => true,
            'message' => 'Job saved successfully'
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
       $job = Job::where([
        'id' => $id,
        'status' => 1
        ])->with(['jobType','category'])->first();
         if ($job == null) {
            abort(404);
        }
        $count = 0;
        if(Auth::check()) {
           $count = SavedJob::where([
              'user_id' => Auth::user()->id,
              'job_id' => $id
          ])->count();
        }
        // fetch aplications count
        $apps = jobApplication::where('job_id', $id)->with('user')->get();

        return view('front.job-detail', compact('job','count','apps'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function applyJob(Request $request)
    {
        //
        $id = $request->id;

         $job = Job::where('id',$id)->first();

         // Check if job exists in db
         if ($job == null) {
            $message = 'Job not found';
            session()->flash('error', 'Job not found');
             return response()->json([
                'status' => false,
                'message' => $message
                ]);
         }
           // you cannot apply for your own job
         $employer_id = $job->user_id;
         if($employer_id == Auth::user()->id) {
            $message = 'You cannot apply for your own job';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' =>  $message
            ]);
             // Here you can add logic to handle the job application, e.g., save to database, send email, etc.
         }
          //you can  apply for a job twice
          $jobApplication = jobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
         ])->count();

         if ($jobApplication > 0) {
            session()->flash('error', 'You have already applied for this job');
            $message = 'You have already applied for this job';
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
         }

         // Create a new job application
         $application = new jobApplication();
         $application->user_id = Auth::user()->id;
         $application->employer_id = $employer_id;
         $application->applied_at = now();
            $application->job_id = $id;
         $application->save();

         // Send email notification to the employer

            $employer = User::where('id', $employer_id)->first();
            $mailData = [
                'employer' => $employer,
                'user' => Auth::user(),
                'job' => $job
            ];

            Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message = 'Application submitted successfully';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
