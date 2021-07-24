<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Auth;

class JobCategoryController extends Controller
{
    public function index(){
        $jobCategories = JobCategory::all();
        return response()->json([
            "status"=>true,
            "message"=>"OK.",
            "data"=> $jobCategories
        ],200);

    }
    public function store(Request $req){

    $req->validate([
        "title"=>"required|string|unique:job_categories,title"
    ]);
        $jobCategory = new JobCategory();
        $jobCategory->title = $req->title;
        $jobCategory->user_id = Auth::user()->id;
        $jobCategory->save();

        return response()->json([
            "status"=>201,
            "message"=>"Job Category Created",
            "data"=> $jobCategory
        ],201);
    }
}
