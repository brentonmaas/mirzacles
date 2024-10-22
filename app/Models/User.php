<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * Retrieve the default photo from storage.
     * Supply a base64 png image if the `photo` column is null.
     *
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        if ($this->profile_photo_path) {
            return asset($this->profile_photo_path);
        }

        // Change the path to the default image
        $defaultImagePath = public_path('images/user-avatar.png');

        // Get the image content
        $imageContent = file_get_contents($defaultImagePath);

        // Encode the image content to base64
        $base64Image = 'data:image/png;base64,' . base64_encode($imageContent);

        return $base64Image;
    }

    /**
     * Retrieve the user's full name in the format:
     * [firstname] [mi?] [lastname]
     * Where:
     * [ mi?] is the optional middle initial.
     *
     * @return string
     */
    public function getFullnameAttribute(): string
    {
        $firstname = $this->firstname;
        $middlename = $this->middlename;
        $lastname = $this->lastname;

        // Get the middle initial if middlename is not empty
        $middleInitial = $middlename ? $this->getMiddleinitialAttribute() : '';

        return trim("{$firstname} {$middleInitial} {$lastname}");
    }

    /**
     * Retrieve the user's middle initial.
     * E.g., "delos Santos" -> "D."
     *
     * @return string
     */
    public function getMiddleinitialAttribute(): string
    {
        $middlename = $this->middlename;

        // Get the middle initial if middlename is not empty
        return $middlename ? strtoupper(substr($middlename, 0, 1)) . '.' : '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'profile_photo_path',
        'firstname',
        'lastname',
        'middlename',
        'prefixname',
        'suffixname',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
