<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\JobCategory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_no_user_before_creating()
    {
        $eloquent = app(User::class);
        $this->assertEmpty($eloquent->get()); 
    }
    public function test_user_has_name()
    {
        $user = User::Factory()->create();
        $this->assertNotEmpty($user->name);
    }
    public function test_user_has_job_categories()
    {
        $count = random_int(1,10);
        $user = User::Factory()->create();
        $jc = JobCategory::Factory($count)->create([
            "user_id" => $user->id
        ]);
        $this->assertEquals($count,count($user->refresh()->job_categories));
    }
}
