<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use App\Models\SavedJob;
use App\Mail\RestPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\jobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class AuthController extends Controller
{
    //
    public function login()
    {
        // Handle the login logic here
        return view('front.account.login');
    }
    public function Registration()
    {
        // Handle the logout logic here
        return view('front.account.registration');
    }
    public function process(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => 'required|string|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            session()->flash('success','you registerd succefully');
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



        //     // Record the user
        //     $user = $request->record($request->all());

        //     // Redirect or return response
        //     return redirect()->route('home')->with('success', 'Registration successful!');

    }
    public function auth(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
        if ($validator->passes()) {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('profile')->with('status', 'Login successful!');
                // Authentication passed...
            } else {
                return redirect()->route('login')->with('error', 'Invalid credentials');
            }
        } else {
            return redirect()->route('login')->withErrors($validator)->withInput($request->only('email'));
        }
    }

    public function profile()
    {


        $id = Auth::id();
        $user = User::where('id', $id)->first();
        // Handle the profile logic here
        $data['user'] = $user;
        return view('front.account.profile', $data);
    }
    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'designation' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'Profile updated successfully!');
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
    public function logout()
    {
        // Handle the logout logic here
        auth()->logout();
        return redirect()->route('home')->with('status', 'Logged out successfully!');
    }
    public function profilepicture(Request $request)
    {

        $id = Auth::user()->id;
        // Handle the profile picture logic here
        $validator = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->passes()) {


            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = $id . '.' . time() . '.' . $ext;
            $file->move(public_path('uploads/image'), $filename);

            // Delete old image if exists
            File::delete(public_path('uploads/image/' . Auth::user()->image));

            User::where('id', $id)->update(['image' => $filename]);

            session()->flash('success', 'Profile picture updated successfully!');

    return response()->json([
        'status' => true,
        'errors' => []
    ]);
}else {
    return response()->json([
        'status' => false,
        'errors' => $validator->errors()
    ]);

}
    }
    public function create()
    {
        // Handle the create account logic here
        $jobTypes  = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['jobTypes'] = $jobTypes;
        return view('front.account.job.create', $data);
    }
    public function Job(Request $request)
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
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->user_id = Auth::user()->id;
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
            $job->save();

            session()->flash('success', 'Job created successfully!');
            return response()->json([
                'status' => true,
                'message' => 'Job created successfully!',
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

         return view('front.account.job.create');

    }
    public function JobList()
    {
        // Handle the job list logic here
        $jobs = Job::where('user_id', Auth::user()->id)->with('JobType')->orderBy('created_at', 'DESC')->paginate(5);
        // dd($jobs);
        $data['jobs'] = $jobs;
        return view('front.account.job.myjob', $data);
    }
    public function editjob($id)
    {

        $jobTypes = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();
        $data['jobTypes'] = $jobTypes;
        $data['categories'] = $categories;
        $data['job'] = $job;
        return view('front.account.job.edit', $data);
    }
    public function updateJob(Request $request, $id)
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
            $job->user_id = Auth::user()->id;
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
    public function deleteJob(Request $request)
    {

        $job = Job::where([
            'user_id' => Auth()->user()->id,
            'id' => $request->jobId
        ])
            ->first();
        if ($job == null) {
            session()->flash('error', 'Either Job Not Found');
            return response()->json([
                'status' => true
            ]);
        }
        Job::where('id', $request->jobId)->delete();
        session()->flash('success', 'job deleted successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully.'
        ]);
    }

    public function jobapply(){
     $jobapplications = jobApplication::where('user_id',Auth::user()->id)->with(['job','job.JobType'])->orderBy('created_at', 'desc')->paginate(10);
//dd($jobapplications);
        $data['jobapplications'] = $jobapplications;
        return view('front.account.job.job-apply',$data);
    }
    public function removeJob(Request $request){

     $jobApplication = jobApplication::where([
        'id' => $request->id , 'user_id' => Auth::user()->id]
        )->first();

     if($jobApplication == null){
        session()->flash('error', 'Job application not found.');
        return response()->json([
            'status' => false,
            'message' => 'Job application not found.'
        ]);
    }
     jobApplication::find($request->id)->delete();
        session()->flash('success', 'Job application removed successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Job application removed successfully.'
        ]);
        }
        public function savedjobs(Request $request){
  $savedJobs = SavedJob::where('user_id',Auth::user()->id)->with(['job','job.JobType'])->orderBy('created_at', 'desc')->paginate(10);
//dd($jobapplications);
        $data['savedJobs'] = $savedJobs;
        return view('front.account.job.saved-job',$data);
        }

        public function removesavedJob(Request $request){

     $savedJob = SavedJob::where([
        'id' => $request->id , 'user_id' => Auth::user()->id]
        )->first();

     if($savedJob == null){
        session()->flash('error', 'Saved job not found.');
        return response()->json([
            'status' => false,
            'message' => 'Saved job not found.'
        ]);
    }
     SavedJob::find($request->id)->delete();
        session()->flash('success', 'Saved job removed successfully.');
        return response()->json([
            'status' => true,
            'message' => 'Saved job removed successfully.'
        ]);
        }

        public function changepassword(Request $request)
        {
           $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
           ]);
           if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors(),
            ]);
        }
            if (Hash::check($request->old_password, Auth::user()->password) == false){
                 session()->flash('error','your old password is incorect');
                  return response()->json([
                     'status' => true,
                     'errors' => $validator->errors(),
                  ]);
                }

             $user = User::find(Auth::user()->id);
             $user->password = Hash::make($request->new_password);
             $user->save();

             session()->flash('success','password updaetd successfuly');
             return response()->json([
                 'status'=> true
             ]);

        }
        public function forgotpassword(){
            return view('front.account.forgotpassword');
        }

        public function forgotPasswordProcess(Request $request){
            $validator = Validator::make($request->all(),[
                'email' => 'required|email|exists:users,email',
            ]);
            if ($validator->fails()){
                return redirect()->route('account.forgot.password')->withErrors($validator)->withInput();
            }
            $token = Str::random(60);
            DB::table('password_reset_tokens')->where('email',$request->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);
            // Here you can implement the logic to send a password reset link to the user's email.

            // send mail to user with the token link
            $user = User::where('email',$request->email)->first();
            $mailData = [
                'token' => $token,
                 'user' => $user,
                 'subject' => 'Reset to Change your password'
            ];
            Mail::to($request->email)->send(new RestPassword($mailData));
               return redirect()->route('account.forgot.password')->with('success','We have emailed your password reset link!');
        }

        public function resetpassword($tokenString){
        $token =   DB::table('password_reset_tokens')->where('token',$tokenString)->first();
         if ($token == null){
            return redirect()->route('account.forgot.password')->with('error','Token invalid');
         }
         return view('front.account.resetpassword',['tokenString' => $tokenString]);
        }
        public function ProccessResetPassword(Request $request){

                $token =   DB::table('password_reset_tokens')->where('token', $request->token)->first();
         if ($token == null){
            return redirect()->route('account.forgot.password')->with('error','Token invalid');
         }

            $validator = Validator::make($request->all(),[
                'new_password' => 'required|min:5',
                'confirm_password' => 'required|same:new_password',
            ]);
            if ($validator->fails()){
                return redirect()->route('account.reset.password', ['tokenString' => $request->token])->withErrors($validator)->withInput();
            }
            User::where('email',$token->email)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->route('login')->with('success','Your password has been changed successfully');
        }
}
