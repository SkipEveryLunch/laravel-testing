<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\JobCategory;
use Laravel\Sanctum\Sanctum;

class JobCategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_jobCategory_belongs_to_user():void{
        $user = User::factory()->create();
        $jc = JobCategory::factory()->create([
            "user_id" => $user->id
        ]);
        $this->assertNotEmpty($jc->user);
    }
    public function test_createCategory_success_categoryCreated():void{
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $title = "Engineering";
        $payload  = [
            "title" => $title
        ];
        $headers  = [
            "Accept"=>"application/json"
        ];
        $res = $this->post("/api/job-categories",$payload,$headers);
        $res->assertJson([
            "status"=>201,
            "message"=>"Job Category Created",
            "data"=>[
                "title"=>$title,
                "user_id"=>$user->id
            ] 
        ]);
        $res->assertStatus(201);
        JobCategory::factory(10)->create();
        $this->assertDatabaseCount("job_categories",11);
    }
    public function test_checkRequiredFields_failure_validationErrorReturned():void{
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $payload  = [
        ];
        $headers  = [
            "Accept"=>"application/json"
        ];
        $res = $this->post("/api/job-categories",$payload,$headers);
        $res->assertJson([
            "status"=>false,
            "message"=>"Validation failed",
            "data"=>null,
            "error"=>[
                "title"=>[
                    "The title field is required."
                ]
            ]
        ])->assertStatus(422);
    }
    public function test_getJobCategories_success_jobCategoriesRetrieved():void{
        $jc1 = JobCategory::factory()->create();
        $jc2 = JobCategory::factory()->create();
        $headers  = [
            "Accept"=>"application/json"
        ];
        $res = $this->get("/api/job-categories",$headers);
        $res->assertJson([
            "status"=>true,
            "message"=>"OK.",
            "data"=>[
                [
                    "id"=>$jc1->id,
                    "title"=>$jc1->title,
                    "user_id"=>$jc1->user_id,
                ],
                [
                    "id"=>$jc2->id,
                    "title"=>$jc2->title,
                    "user_id"=>$jc2->user_id,
                ]
            ]
        ]);
    }
}
