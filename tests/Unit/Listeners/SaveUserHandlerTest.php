<?php

namespace Tests\Unit\Listeners;

use App\Events\UserSaved;
use App\Listeners\SaveUserBackgroundInformation;
use App\Models\User;
use App\Observers\UserObserver;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class SaveUserHandlerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_it_handles_event_and_calls_user_service()
    {
        // Arrangements
        $user = User::factory()->create(['id' => 1]);

        $userServiceMock = Mockery::mock(UserService::class);
        $this->app->instance(UserService::class, $userServiceMock);

        $userServiceMock->shouldReceive('updateDetails')
            ->once()
            ->withArgs(function ($passedUser) use ($user) {
                return $passedUser->is($user);
            });

        // Actions
        $listener = $this->app->make(SaveUserBackgroundInformation::class);

        $event = new UserSaved($user);
        $listener->handle($event);

        // Assertions
        $userServiceMock->shouldHaveReceived('updateDetails')
            ->with(Mockery::on(function($passedUser) use ($user) {
                return $passedUser->is($user);
            }))
            ->once();

        // need this to prevent test from being risky
        $this->assertTrue(true);

        Mockery::close();
    }
}
