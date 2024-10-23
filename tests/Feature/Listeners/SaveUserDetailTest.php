<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use App\Events\UserSaved;
use Illuminate\Foundation\Testing\RefreshDatabase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class SaveUserDetailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_event_when_user_is_saved()
    {
        Event::fake([UserSaved::class]);

        // Arrangements
        $this->app->register(\App\Providers\AppServiceProvider::class);

        $user = User::factory()->create();

        $userService = app(UserService::class);

        // Actions
        $updated = $userService->update($user->id, ['name' => 'Updated Name']);

        // Assertions
        $this->assertTrue($updated);

        Event::assertDispatched(UserSaved::class, function ($event) use ($user) {
            return $event->user->is($user);
        });
    }
}
