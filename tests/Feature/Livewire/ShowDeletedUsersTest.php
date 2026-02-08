<?php
/*
Livewire tests that test the ShowDeletedUsers livewire component. The component is responsible for rendering and restoring deleted users.
*/
namespace Tests\Feature\Livewire;

use Livewire\Livewire;
use App\Models\User;
use App\Livewire\ShowDeletedUsers;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowDeletedUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_renders_successfully()
    {
        Livewire::test(ShowDeletedUsers::class)
            ->assertStatus(200);
    }


    /** @test */
    public function test_only_admins_can_view_component()
    {
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);
        $user = User::factory()->create([
            'role' => "gost",
        ]);
        $response = $this->actingAs($userAdmin)->get('deleted-users');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('deleted-users');
        $response->assertStatus(403);
    }


    /** @test */
    public function test_component_exists_on_the_page()
    {
        $user = User::factory()->create([
            'role' => "admin",
        ]);
        $response = $this->actingAs($user)->get('deleted-users')
            ->assertSeeLivewire(ShowDeletedUsers::class);
        $response->assertStatus(200);
    }

    /** @test */
    public function test_displays_deleted_users()
    {

        User::factory()->create(['name' => 'Kenan Hikmetov', 'deleted_at' => date("Y-m-d H:i:s")]);
        User::factory()->create(['name' => 'Kemal Nijazov', 'deleted_at' => date("Y-m-d H:i:s")]);
        Livewire::test(ShowDeletedUsers::class)
            ->assertSee('Kenan Hikmetov')
            ->assertSee('Kemal Nijazov');
    }
    /** @test */
    public function test_only_admin_can_restore_users()
    {

        $user = User::factory()->create(['name' => 'Kenan Hikmetov', 'role' => "gost"]);

        $userId = $user["id"];
        $arrayUsers = [$userId];
        Livewire::actingAs($user)->test(ShowDeletedUsers::class)->set('checkBox', $arrayUsers)->call('restoreUser', $arrayUsers)->assertStatus(403);
    }
    /** @test */
    public function test_restoring_deleted_users()
    {

        $user1 = User::factory()->create(['name' => 'Kenan Hikmetov', 'role' => "gost", 'deleted_at' => date("Y-m-d H:i:s")]);
        $user2 = User::factory()->create(['name' => 'Kemal Nijazov', 'role' => "gost", 'deleted_at' => date("Y-m-d H:i:s")]);
        $userAdmin = User::factory()->create([
            'role' => "admin",
        ]);

        $user1Id = $user1["id"];
        $user2Id = $user2["id"];

        $arrayUsers = [$user1Id, $user2Id];

        $this->actingAs($userAdmin);
        $this->assertDatabaseHas('users', [
            'id' => $user1->id,
            'deleted_at' => date("Y-m-d H:i:s"),
        ]);

        Livewire::test(ShowDeletedUsers::class)->set('checkBox', $arrayUsers)->call('restoreUser');

        $this->assertDatabaseHas('users', [
            'id' => $user1->id,
            'deleted_at' => null,
            'id' => $user2->id,
            'deleted_at' => null,
        ]);
    }
}
