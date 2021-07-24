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
                "id" => 1,
                "title"=>$title,
                "user_id"=>$user->id
            ] 
        ]);
        $res->assertStatus(201);
        JobCategory::factory(10)->create();
        $this->assertDatabaseCount("job_categories",11);
    }
}
