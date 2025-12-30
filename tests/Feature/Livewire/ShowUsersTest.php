<?php
/*
Livewire tests that test the ShowUsers livewire component. The component is responsible for rendering and restoring users.
*/
namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\User;
use App\Livewire\ShowUsers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {
        Livewire::test(ShowUsers::class)
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
        $response = $this->actingAs($userAdmin)->get('users');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('users');
        $response->assertStatus(403);
    }

    /** @test */
    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $response = $this->actingAs($user)->get('users')
            ->assertSeeLivewire(ShowUsers::class);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_displays_users()
    {

        User::factory()->create(['name' => 'Kenan Hikmetov']);
        User::factory()->create(['name' => 'Kemal Nijazov']);
        Livewire::test(ShowUsers::class)
            ->assertSee('Kenan Hikmetov')
            ->assertSee('Kemal Nijazov');
    }

    /** @test */
    public function test_displays_all_users_data()
    {
        User::factory()->create(['name' => 'Kenan Hikmetov']);
        User::factory()->create(['name' => 'Kemal Nijazov']);
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $this->actingAs($user);

        Livewire::test(ShowUsers::class)
            ->assertViewHas('users', function ($users) {
                return  count($users) == 3;
            });
    }

    /** @test */
    public function test_only_admin_can_delete_users()
    {

        $user = User::factory()->create(['name' => 'Kenan Hikmetov', 'role' => "guest"]);

        $userId = $user["id"];
        $arrayUsers = [$userId];
        Livewire::actingAs($user)->test(ShowUsers::class)->set('checkBox', $arrayUsers)->call('deleteUser', $arrayUsers)->assertStatus(403);
    }

    /** @test */
    public function test_deleting_users()
    {

        $user1 = User::factory()->create(['name' => 'Kenan Hikmetov', 'role' => "guest"]);
        $user2 = User::factory()->create(['name' => 'Kemal Nijazov', 'role' => "guest"]);
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $user1Id = $user1["id"];
        $user2Id = $user2["id"];

        $arrayUsers = [$user1Id, $user2Id];

        $this->actingAs($userAdmin);
        $this->assertDatabaseHas('users', [
            'id' => $user1->id,
            'deleted_at' => null,
        ]);

        Livewire::test(ShowUsers::class)->set('checkBox', $arrayUsers)->call('deleteUser', $arrayUsers);

        $this->assertDatabaseHas('users', [
            'id' => $user1->id,
            'deleted_at' => date("Y-m-d H:i:s"),
            'id' => $user2->id,
            'deleted_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
