<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    /**
     * Define the validation rules for the model.
     *
     * @param int|null $id
     * @return array
     */
    public function rules(?int $id = null): array;

    /**
     * Retrieve all resources and paginate.
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function list(int $perPage = 15): LengthAwarePaginator;

    /**
     * Create model resource.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $attributes): Model;

    /**
     * Retrieve model resource details.
     * Abort to 404 if not found.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id): ?Model;

    /**
     * Update model resource.
     *
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Soft delete model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function destroy(int|array $id): void;

    /**
     * Include only soft deleted records in the results.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function listTrashed(): LengthAwarePaginator;

    /**
     * Restore model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function restore(int|array $id): void;

    /**
     * Permanently delete model resource.
     *
     * @param int|array $id
     * @return void
     */
    public function delete(int|array $id): void;

    /**
     * Generate random hash key.
     *
     * @param string $key
     * @return string
     */
    public function hash(string $key): string;

    /**
     * Upload the given file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string|null
     */
    public function upload(UploadedFile $file): ?string;

    /**
     * Get total rows.
     *
     * @return int
     */
    public function total(): int;

    /**
     * Get total of all trashed rows.
     *
     * @return int
     */
    public function totalTrashed(): int;

    /**
     * Update the details table.
     *
     * @param User $user
     * @return void
     */
    public function updateDetails(User $user): void;
}
