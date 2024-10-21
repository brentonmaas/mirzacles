<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
        return view('users.edit', compact('nav'));
    }

    public function edit($id)
    {
        $nav = 'Edit';
        return view('users.edit', compact('nav', 'id'));
    }

    public function destroy($id)
    {
        $nav = 'Users';
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

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',  // Password validation
            'confirm_password' => 'required_with:password|string|min:8', // Confirm Password validation
            'email' => 'required|email|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'prefixname' => 'required|string|max:3',
            'suffixname' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'photo' => 'nullable|file|max:2048',
        ]);

        // Retrieve the user record
        $user = User::findOrFail($id);

        // Update the user fields
        $user->name = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->middlename = $validatedData['middlename'];
        $user->prefixname = $validatedData['prefixname'];
        $user->suffixname = $validatedData['suffixname'];
        $user->type = $validatedData['type'];

        // If a new password is provided
        if ($request->filled('password') && $validatedData['password'] != 'password') {
            $user->password = Hash::make($validatedData['password']);
        }

        // If a photo is uploaded
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->profile_photo_path = $photoPath;
        }

        $user->save();

        // Redirect or return a response
        return redirect()->route('users.index')->with('success', 'User added/updated successfully!');
    }

}
