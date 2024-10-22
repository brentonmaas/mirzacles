<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Authenticate a user before each test
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    #[Test]
    public function it_can_display_the_user_index()
    {
        // Actions
        $response = $this->get(route('users.index'));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('nav', 'Users');
    }

    #[Test]
    public function it_can_show_a_specific_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $response = $this->get(route('users.show', $user->id));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHasAll(['nav', 'Show']);
        $response->assertViewHas('id', $user->id);
    }

    #[Test]
    public function it_can_display_the_create_user_view()
    {
        // Actions
        $response = $this->get(route('users.create'));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('users.create');
        $response->assertViewHas('nav', 'Create');
    }

    #[Test]
    public function it_can_display_the_edit_user_view()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $response = $this->get(route('users.edit', $user->id));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHasAll(['nav', 'id']);
        $response->assertViewHas('nav', 'Edit');
        $response->assertViewHas('id', $user->id);
    }

    #[Test]
    public function it_can_delete_a_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $response = $this->delete(route('users.destroy', $user->id));

        // Assertions
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User moved to trash!');
        $this->assertSoftDeleted($user);
    }

    #[Test]
    public function it_returns_error_when_deleting_non_existent_user()
    {
        // Actions
        $response = $this->delete(route('users.destroy', 999));

        // Assertions
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error', 'User Not Found!');
    }

    #[Test]
    public function it_can_display_trashed_users()
    {
        // Actions
        $response = $this->get(route('users.trashed'));

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('users.trashed');
        $response->assertViewHas('nav', 'Trashed');
    }

    #[Test]
    public function it_can_restore_a_trashed_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $response = $this->patch(route('users.restore', $user->id));

        // Assertions
        $response->assertRedirect(route('users.trashed'));
        $response->assertSessionHas('success', 'User restored successfully.');
        $this->assertNotSoftDeleted($user);
    }

    #[Test]
    public function it_can_permanently_delete_a_user()
    {
        // Arrangements
        $user = User::factory()->create(['deleted_at' => now()]);

        // Actions
        $response = $this->delete(route('users.delete', $user->id));

        // Assertions
        $response->assertRedirect(route('users.trashed'));
        $response->assertSessionHas('success', 'User deleted permanently.');
        $this->assertDeleted($user);
    }

    #[Test]
    public function it_can_store_a_new_user()
    {
        // Arrangements
        $user = User::factory()->make()->toArray();

        // Actions
        $response = $this->post(route('users.store'), $user);

        unset($user['password_confirmation']);

        // Assertions
        $this->assertDatabaseHas('users', $user);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User created successfully.');
    }

    #[Test]
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();
        $updatedUser = User::factory()->make()->toArray();

        // Actions
        $response = $this->put(route('users.update', $user->id), $updatedUser);
        unset($updatedUser['password_confirmation']);

        // Assertions
        $this->assertDatabaseHas('users', $updatedUser);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User updated successfully.');
    }
}
