<?php
/*
Breeze default user registration tests
*/
namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        RecaptchaV3::shouldReceive('verify')
            ->once()
            ->andReturn(1.0);

        $response = $this->post('/register', [
            'policy'=>true,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'g-recaptcha-response' => 'required|recaptchav3:register,0.5'
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::GUESTHOME);
    }
}
