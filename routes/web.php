<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\admin\DashoardController;
use App\Http\Controllers\admin\JobapplicationController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['prefix'=>'admin','middleware'=>'checkrole'] ,function(){
Route::get('dashboard',[DashoardController::class,'index'])->name('dashboard');
Route::get('/users', [UserController::class,'index'])->name('admin.user');
Route::get('/users/{id}', [UserController::class,'edit'])->name('admin.user.edit');
Route::put('/users/{id}', [UserController::class,'update'])->name('admin.user.update');
Route::delete('/users/{id}', [UserController::class,'destroy'])->name('admin.user.destroy');
Route::get('job',[JobController::class,'index'])->name('job');
Route::get('/job/{id}',[JobController::class,'edit'])->name('admin.job.edit');
Route::put('/job/{id}',[JobController::class,'update'])->name('admin.job.update');
Route::delete('/job/{id}',[JobController::class,'destroy'])->name('admin.job.destroy');
Route::get('/job-application',[JobapplicationController::class,'index'])->name('admin.job-application');
});

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/jobs',[JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/show/{id}',[JobsController::class, 'show'])->name('jobs.show');
Route::post('/apply-job',[JobsController::class, 'applyJob'])->name('apply.job');
Route::post('/save-job',[JobsController::class, 'saveJob'])->name('save.job');

Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('account.forgot.password');
Route::post('forgot-password-process', [AuthController::class, 'forgotPasswordProcess'])->name('account.forgot-password-process');
Route::get('reset-password/{tokenString}', [AuthController::class, 'resetPassword'])->name('account.reset.password');
Route::post('reset-password-process', [AuthController::class, 'ProccessResetPassword'])->name('account.reset.password.process');

Route::group(['prefix' => 'account'],function(){

    Route::group(['middleware' => 'guest'], function () {
       Route::get('account/register', [AuthController::class, 'Registration'])->name('account.registration');
Route::post('account/process', [AuthController::class, 'process'])->name('account.process');
Route::get('account/login', [AuthController::class, 'login'])->name('login');
Route::post('account/auth', [AuthController::class, 'auth'])->name('account.auth');
    });
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/update', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    Route::post('/profilepicture', [AuthController::class, 'profilepicture'])->name('account.profilepicture');
     Route::get('/create', [AuthController::class, 'create'])->name('account.create');
     Route::post('/job', [AuthController::class, 'Job'])->name('account.Job');
     Route::get('/joblist', [AuthController::class, 'jobList'])->name('account.jobList');
     Route::get('/edit/{jobId}', [AuthController::class, 'editjob'])->name('account.editjob');
      Route::post('/update-job{jobId}', [AuthController::class, 'updateJob'])->name('account.updateJob');
      Route::post('/delete-job', [AuthController::class, 'deleteJob'])->name('account.deleteJob');
        Route::get('/job-apply', [AuthController::class, 'jobapply'])->name('account.jobapply');
        Route::post('/remove-job-app', [AuthController::class, 'removeJob'])->name('account.removeJob');
        Route::get('/saved-jobs', [AuthController::class, 'savedjobs'])->name('account.savedjobs');
        Route::post('/remove-saved-job', [AuthController::class, 'removeSavedJob'])->name('account.removeSavedJob');
        Route::post('/change-password', [AuthController::class,'changepassword' ])->name('account.changepassword');
    });

});
