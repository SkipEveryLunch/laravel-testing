<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function store(Request $req){
        $job = Job::create(
            $req->only(
                "title",
                "description",
                "location",
                "requirement",
                "job_category_id"
            )+["user_id"=>Auth::user()->id]
        );
        return response()->json([
                "status"=>true,
                "message"=>"Job created",
                "data"=>$job
            ]);
    }
    public function update(Request $req,$id){
        $job = Job::find($id);
        if(!$job){
            return response()->json([
                "status"=>false,
                "message"=>"no such job posted by you",
                "data"=>null
            ],404);
        }
        $job->update(
            $req->only(
                "title",
                "description",
                "location",
                "requirement",
                "job_category_id"
            )
        );
        return response()->json([
                "status"=>true,
                "message"=>"Job updated",
                "data"=>$job
            ]);
    }
}
