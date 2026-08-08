<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->string('name')->toString(),
                'email' => $request->string('email')->toString(),
                'password' => $request->string('password')->toString(),
            ]);

            $tenant = Tenant::create([
                'name' => $request->string('tenant_name')->toString(),
                'slug' => $request->string('tenant_slug')->toString(),
            ]);

            $user->tenants()->attach($tenant->id);

            $token = $user->createToken('api')->plainTextToken;

            return compact('user', 'tenant', 'token');
        });

        return response()->json([
            'user' => $result['user'],
            'tenant' => new TenantResource($result['tenant']),
            'token' => $result['token'],
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where(
            'email',
            $request->string('email')->toString()
        )->first();

        if (!$user || !Hash::check(
            $request->string('password')->toString(),
            $user->password
        )) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        $user->load('tenants');

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'user' => $user,
            'tenants' => TenantResource::collection($user->tenants),
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function me(): JsonResponse
    {
        $user = request()->user()->load('tenants');

        return response()->json([
            'user' => $user,
            'tenants' => TenantResource::collection($user->tenants),
        ]);
    }
}
