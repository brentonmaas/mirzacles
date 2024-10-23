<?php

namespace Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

#[RunTestsInSeparateProcesses]
#[PreserveGlobalState(false)]
class CreateUserMigrationsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function users_table_has_expected_columns()
    {
        // Arrangements
        $this->assertTrue(Schema::hasTable('users'));

        $columns = [
            'id', 'prefixname', 'firstname', 'middlename', 'lastname',
            'suffixname', 'name', 'email', 'password', 'profile_photo_path',
            'type', 'remember_token', 'email_verified_at', 'current_team_id',
            'created_at', 'updated_at',
        ];

        // Actions & Assertions: Check each expected column
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('users', $column));
        }
    }

    #[Test]
    public function password_reset_tokens_table_has_expected_columns()
    {
        // Arrangements
        $this->assertTrue(Schema::hasTable('password_reset_tokens'));

        $columns = [
            'email', 'token', 'created_at'
        ];

        // Actions & Assertions: Check each expected column
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('password_reset_tokens', $column));
        }
    }

    #[Test]
    public function sessions_table_has_expected_columns()
    {
        // Arrangements
        $this->assertTrue(Schema::hasTable('sessions'));

        $columns = [
            'id', 'user_id', 'ip_address', 'user_agent',
            'payload', 'last_activity',
        ];

        // Actions & Assertions: Check each expected column
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('sessions', $column));
        }
    }
}
