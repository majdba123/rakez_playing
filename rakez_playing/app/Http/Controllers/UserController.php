<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Store a new user
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:users,email',
        ]);

        $result = User::createUser(
            $request->name,
            $request->phone,
            $request->email
        );

        return response()->json($result, $result['success'] ? 201 : 200);
    }

    /**
     * Check if phone exists
     */
    public function checkPhone(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        if (User::phoneExists($request->phone)) {
            return response()->json([
                'exists' => true,
                'message' => 'You are already registered'
            ]);
        }

        return response()->json([
            'exists' => false,
            'message' => 'Phone number is available'
        ]);
    }
}