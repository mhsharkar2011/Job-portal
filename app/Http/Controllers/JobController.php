<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['jobs'] = Job::all();
        return view('jobs.applied-job',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.post-job');
    }
    public function created()
    {
        return view('jobs.created-job');
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
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
