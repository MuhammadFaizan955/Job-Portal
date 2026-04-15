<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $featurejobs = Job::where('status',1)->with('JobType')->orderBy('created_at','DESC')->where('isFeatured',0)->take(6)->get();
        $categories =   Category::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
        $newcategories =   Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $latestjobs = Job::where('status',1)->with('JobType')->where('isFeatured',0)->orderBy('created_at','DESC')->take(6)->get();
        $data['categories'] = $categories;
        $data['featurejobs'] = $featurejobs;
        $data['latestjobs'] = $latestjobs;
        $data['newcategories'] = $newcategories;
        return view('front.home',$data); // Assuming you want to return the welcome view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    }

    /**
     * Show the form for editing the specified resource.
     */
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
