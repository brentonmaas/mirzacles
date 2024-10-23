<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService(new User(), new Request());
    }

    #[Test]
    public function it_can_return_a_paginated_list_of_users()
    {
        // Arrangements
        User::factory()->count(50)->create();

        // Actions
        $users = $this->userService->list(10);

        // Assertions
        $this->assertCount(10, $users);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $users);
    }

    #[Test]
    public function it_can_store_a_user_to_database()
    {
        // Arrangements
        $data = User::factory()->make()->toArray();
        $data['password'] = 'password';

        // Actions
        $newUser = $this->userService->store($data);

        // Assertions
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $this->assertInstanceOf(User::class, $newUser);
    }

    #[Test]
    public function it_can_find_and_return_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $foundUser = $this->userService->find($user->id);

        // Assertions
        $this->assertNotNull($foundUser);
        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    #[Test]
    public function it_can_update_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();
        $data = ['name' => 'Updated Name'];

        // Actions
        $updated = $this->userService->update($user->id, $data);

        // Assertions
        $this->assertTrue($updated);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated Name']);
    }

    #[Test]
    public function it_can_soft_delete_an_existing_user()
    {
        // Arrangements
        $user = User::factory()->create();

        // Actions
        $this->userService->destroy($user->id);

        // Assertions
        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_can_return_a_paginated_list_of_trashed_users()
    {
        // Arrangements
        $users = User::factory()->count(30)->create();
        foreach ($users as $user) {
            $this->userService->destroy($user->id);
        }

        // Actions
        $trashedUsers = $this->userService->listTrashed(10);

        // Assertions
        $this->assertCount(10, $trashedUsers);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $trashedUsers);
    }

    #[Test]
    public function it_can_restore_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create();
        $this->userService->destroy($user->id);

        // Actions
        $this->userService->restore($user->id);

        // Assertions
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    #[Test]
    public function it_can_permanently_delete_a_soft_deleted_user()
    {
        // Arrangements
        $user = User::factory()->create();
        $this->userService->destroy($user->id);

        // Actions
        $this->userService->delete($user->id);

        // Assertions
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_can_upload_photo()
    {
        // Arrangements
        Storage::fake('public');
        $file = UploadedFile::fake()->image('photo.jpg');

        // Actions
        $photoUrl = $this->userService->upload($file);

        // Assertions
        Storage::disk('public')->assertExists('photos/' . $file->hashName());
        $this->assertStringContainsString('photos/', $photoUrl);
    }

    #[Test]
    public function it_can_count_the_total_existing_users()
    {
        // Arrangements
        $initialCount = User::count();
        User::factory()->count(5)->create();

        // Actions
        $totalUsers = $this->userService->total();

        // Assertions
        $this->assertEquals($initialCount + 5, $totalUsers);
    }

    #[Test]
    public function it_can_count_the_total_trashed_users()
    {
        // Arrangements
        $initialCount = User::onlyTrashed()->count();
        $users = User::factory()->count(10)->create();
        foreach ($users->take(4) as $user) {
            $user->delete();
        }

        // Actions
        $totalTrashedUsers = $this->userService->totalTrashed();

        // Assertions
        $this->assertEquals($initialCount + 4, $totalTrashedUsers);
    }

    #[Test]
    public function it_can_update_user_details()
    {
        // Arrangements
        $user = User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'middlename' => 'Middle',
            'prefixname' => 'Mr',
            'suffixname' => 'Jr',
        ]);

        // Actions
        $this->userService->updateDetails($user);

        // Assertions
        $this->assertDatabaseHas('details', [
            'key' => 'Full name',
            'value' => $user->getFullnameAttribute() . ' ' . $user->suffixname,
            'type' => 'bio',
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('details', [
            'key' => 'Middle Initial',
            'value' => $user->getMiddleInitialAttribute(),
            'type' => 'bio',
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('details', [
            'key' => 'Avatar',
            'value' => $user->getAvatarAttribute(),
            'type' => 'bio',
            'user_id' => $user->id
        ]);
        $this->assertDatabaseHas('details', [
            'key' => 'Gender',
            'value' => $user->getGenderAttribute(),
            'type' => 'bio',
            'user_id' => $user->id
        ]);
    }
}
