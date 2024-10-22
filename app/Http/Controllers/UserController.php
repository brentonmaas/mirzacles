<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $nav = 'Users';
        return view('users.index', compact('nav'));
    }

    public function show($id)
    {
        $nav = 'Show';
        return view('users.show', compact('nav', 'id'));
    }

    public function create()
    {
        $nav = 'Create';
        return view('users.create', compact('nav'));
    }

    public function edit($id)
    {
        $nav = 'Edit';
        return view('users.edit', compact('nav', 'id'));
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        } else {
            return redirect()->route('users.index')->with('error', 'User Not Found!');
        }

        return redirect()->route('users.index')->with('success', 'User moved to trash!');
    }


    public function trashed()
    {
        $nav = 'Trashed';
        return view('users.trashed', compact('nav'));
    }


    // Restore a specific trashed user.
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
    }

    // Permanently delete a specific user.
    public function delete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('users.trashed')->with('success', 'User deleted permanently.');
    }

    public function store(UserRequest $request)
    {
        // Extract validated attributes from the request
        $attributes = $request->validated();

        // Call the user service's store method with the validated attributes
        $this->userService->store($attributes);

        // Redirect to the users index route with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(UserRequest $request, $id)
    {
        // Extract validated attributes from the request
        $attributes = $request->validated();

        // Call the user service's update method with the user ID and validated attributes
        $this->userService->update($id, $attributes);

        // Redirect to the users index route with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
