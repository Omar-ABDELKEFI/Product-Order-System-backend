<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function updateAllPasswords(Request $request)
    {
        // Assuming you want to set a common password for all users
        $newPassword = Hash::make($request->input('new_password'));

        // Update all user passwords
        User::query()->update(['password' => $newPassword]);

        // Return a response indicating success
        return response(['message' => 'Passwords updated successfully'], 200);
    }
}
