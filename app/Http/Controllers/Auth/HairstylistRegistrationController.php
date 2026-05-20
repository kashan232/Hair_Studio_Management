<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HairstylistRegistrationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $hairstylistRole = Role::where('slug', 'hairstylist')->firstOrFail();

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $hairstylistRole->id,
            'role' => 'hairstylist',
            'designation' => 'Hairstylist',
            'joining_date' => date('Y-m-d'),
            'status' => 1,
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150',
        ]);

        return response()->json([
            'success' => 'Registration successful! Please sign in with your email and password.',
            'email' => $request->input('email'),
            'show_login' => true,
        ]);
    }
}
