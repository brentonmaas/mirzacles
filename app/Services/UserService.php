<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{
    /**
     * The model instance.
     *
     * @var \App\User
     */
    protected $model;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Constructor to bind model to a repository.
     *
     * @param \App\User $model
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $model, Request $request)
    {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * Define the validation rules for the model.
     *
     * @param int|null $id
     * @return array
     */
    public function rules(?int $id = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'sometimes|nullable|confirmed|string|min:8',  // Password validation
            'password_confirmation' => 'sometimes|nullable|string|min:8', // Confirm Password validation
            'email' => 'required|email|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'prefixname' => 'required|string|max:3',
            'suffixname' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'photo' => 'nullable|file|max:2048',
        ];
    }

    /**
     * Retrieve all resources and paginate.
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
    */
    public function list(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Create model resource.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes): Model
    {
        // Hash the password before saving
        $attributes['password'] = $this->hash($attributes['password']);

        // Create the user
        return $this->model->create($attributes);
    }

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): ?Model
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404, 'User not found.');
        }
    }

    /**
     * Update model resource.
     *
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        $user = $this->model->findOrFail($id);

        if (!empty($attributes['password'])) {
            $attributes['password'] = $this->hash($attributes['password']);
        } else {
            unset($attributes['password']);
        }

        return (bool) $user->update($attributes);
    }

    /**
     * Soft delete model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function destroy(int|array $id): void
    {
        if (is_array($id)) {
            // Multiple delete all users whose IDs are in the array
            $this->model->whereIn('id', $id)->delete();
        } else {
            // Single delete the user with that ID
            $user = $this->model->findOrFail($id);
            $user->delete();
        }
    }

    /**
     * Include only soft deleted records in the results.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listTrashed(int $perPage = 20): LengthAwarePaginator
    {
        return $this->model->onlyTrashed()->paginate($perPage);
    }

    /**
     * Restore model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function restore(int|array $id): void
    {
        if (is_array($id)) {
            $this->model->onlyTrashed()->whereIn('id', $id)->restore();
        } else {
            $user = $this->model->onlyTrashed()->findOrFail($id);
            $user->restore();
        }
    }

    /**
     * Permanently delete model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function delete(int|array $id): void
    {
        if (is_array($id)) {
            $this->model->onlyTrashed()->whereIn('id', $id)->forceDelete();
        } else {
            $user = $this->model->onlyTrashed()->findOrFail($id);
            $user->forceDelete();
        }
    }

    /**
     * Generate random hash key.
     *
     * @param string $key
     * @return string
     */
    public function hash(string $key): string
    {
        return Hash::make($key);
    }

    /**
     * Upload the given file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file): string
    {
        $path = $file->store('photos', 'public');
        return Storage::url($path);
    }

    /**
     * Get total rows.
     *
     * @return int
     */
    public function total(): int
    {
        return User::count();
    }

    /**
     * Get total of trashed rows.
     *
     * @return int
     */
    public function totalTrashed(): int
    {
        return User::onlyTrashed()->count();
    }
}
