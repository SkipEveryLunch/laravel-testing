<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\JobCategory;
use App\Models\Job;
use App\Models\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class JobTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function test_createJob_success_jobCreated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $title = "Web engineer";
        $description = "We are looking for a vibrant web engineer!";
        $location = "Tokyo";
        $requirement = "have ligit understanding of Laravel";
        $jobCategory = JobCategory::factory()->create();
        $headers  = [
            "Accept"=>"application/json"
        ];
        $payload = [
            "title"=>$title,
            "description"=>$description,
            "location"=>$location,
            "requirement"=>$requirement,
            "job_category_id"=>$jobCategory->id,
            "user_id"=>$user->id
        ];
        $res = $this->post("/api/jobs",$payload,$headers);
        $res->assertJson([
            "status"=>true,
            "message"=>"Job created",
            "data"=>[
                "title"=>$title,
                "description"=>$description,
                "location"=>$location,
                "requirement"=>$requirement,
                "job_category_id"=>$jobCategory->id
            ]
        ]);
    }
    public function test_updateJob_success_jobUpdated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $job = Job::factory()->create();
        $title = "Web engineer";
        $description = "We are looking for a vibrant web engineer!";
        $location = "Tokyo";
        $requirement = "have legit understanding of Laravel";
        $jobCategory = JobCategory::factory()->create();
        $headers  = [
            "Accept"=>"application/json"
        ];
        $payload = [
            "title"=>$title,
            "description"=>$description,
            "location"=>$location,
            "requirement"=>$requirement,
            "job_category_id"=>$jobCategory->id,
            "user_id"=>$user->id
        ];
        $res = $this->put("/api/jobs/".$job->id,$payload,$headers);
        $res->assertJson([
            "status"=>true,
            "message"=>"Job updated",
            "data"=>[
                "title"=>$title,
                "description"=>$description,
                "location"=>$location,
                "requirement"=>$requirement,
                "job_category_id"=>$jobCategory->id
            ]
        ]);
    }
}
