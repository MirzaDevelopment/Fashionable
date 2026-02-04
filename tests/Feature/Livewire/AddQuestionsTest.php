<?php
namespace Tests\Feature\Livewire;

use App\Livewire\AddQuestions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Question;
use Tests\TestCase;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class AddQuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {


        Livewire::test(AddQuestions::class)
            ->assertStatus(200);
    }


      /** @test */
    public function test_component_exists_on_the_page()
    {

        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $response = $this->actingAs($userAdmin)->get('/shop')
            ->assertSeeLivewire(AddQuestions::class);
        $response->assertStatus(200);
    }



    /** @test */
    public function test_product_exists_in_database()
    {

        $fakeQuestion=Question::factory()->create(["status"=>"neodgovoreno"]);

        $this->assertDatabaseHas("questions", 
        [ "id" => "1", 
        "user_name" => $fakeQuestion->user_name, 
        "user_email" => $fakeQuestion->user_email, 
        "question" => $fakeQuestion->question, 
        "status"=>"neodgovoreno",
        ]);

        
    }

     /** @test */
    public function test_question_is_uploaded_in_database()
    {
        
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

            Livewire::actingAs($userAdmin)
            ->test(AddQuestions::class)
            ->set('userName', 'John Doe')
            ->set('email', 'john@example.com')
            ->set('question', 'This is a test question.')
            ->set('status', 'neodgovoreno')
            ->call('uploadQuestion')          // call the method
            ->assertHasNoErrors();   
        
     
        $this->assertDatabaseHas('questions', [
            'user_name' => 'John Doe',
            'user_email' => 'john@example.com',
            'question'  => 'This is a test question.',
            'status'    => 'neodgovoreno',
        ]);

    }
      }