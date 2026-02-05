<?php
/*
Livewire tests that test the ShowQuestions livewire component. The component is responsible for rendering comments and questions from user on the admin dashboard.
Tests include standard component render tests, questions delete and modify questions from "odgovoreno" to "neodgovoreno" and vice versa.
*/
namespace Tests\Feature\Livewire;

use App\Livewire\ShowQuestions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Question;
use Tests\TestCase;

class ShowQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {


        Livewire::test(ShowQuestions::class)
            ->assertStatus(200);
    }

  /** @test */
    public function test_only_admins_can_view_component()
    {
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        $user = User::factory()->create([
            'role' => "guest",
        ]);
        $response = $this->actingAs($userAdmin)->get('questions');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('questions');
        $response->assertStatus(403);
    }

        /** @test */
    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $response = $this->actingAs($user)->get('questions')
            ->assertSeeLivewire(ShowQuestions::class);
        $response->assertStatus(200);
    }

     /** @test */
    public function test_displays_questions()
    {

   $fakeQuestion=Question::factory()->create(["status"=>"neodgovoreno"]);


        Livewire::test(ShowQuestions::class)
            ->assertSee($fakeQuestion->user_name)
            ->assertSee($fakeQuestion->user_email);
    }

      /** @test */
    public function test_deleting_questions()
    {

        $fakeQuestion=Question::factory()->create(["status"=>"neodgovoreno"]);
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        
        $this->assertDatabaseHas("questions", 
        [ "id" => $fakeQuestion->id, 
        "user_name" => $fakeQuestion->user_name, 
        "user_email" => $fakeQuestion->user_email, 
        "question" => $fakeQuestion->question, 
        "status"=>"neodgovoreno",
        ]);
        $this->actingAs($userAdmin);
        Livewire::test(ShowQuestions::class)->call('deleteQuestion',$fakeQuestion->id);

        $this->assertDatabaseMissing("questions", 
        [ 
            "id" => $fakeQuestion->id,  
     
        ]);
    }
    
      }