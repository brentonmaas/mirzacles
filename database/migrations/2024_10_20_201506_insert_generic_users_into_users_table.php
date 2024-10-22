<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $faker = Faker::create();
        $prefixnames = ['Mr', 'Mrs', 'Ms']; //only generate from these prefixes

        for ($i=0; $i < 50; $i++) {
            $name = $faker->firstName;
            DB::table('users')->insert([
                'prefixname' => $faker->randomElement($prefixnames),
                'firstname' => $name,
                'middlename' => $faker->firstName,
                'lastname' => $faker->lastName,
                'suffixname' => $faker->suffix,
                'name' => $name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make(Str::random(10)),
                'profile_photo_path' => null,
                'type' => 'user',
                'remember_token' => null,
                'email_verified_at' => null,
                'current_team_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('users')->orderBy('id', 'desc')->limit(50)->delete();
    }
};
