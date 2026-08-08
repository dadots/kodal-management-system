<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->header('X-Tenant-ID');

        if (!$tenantId) {
            return response()->json([
                'message' => 'Tenant ID is required.',
            ], 400);
        }

        $tenant = $request->user()
            ->tenants()
            ->where('tenants.id', $tenantId)
            ->where('tenants.status', 'active')
            ->first();

        if (!$tenant) {
            return response()->json([
                'message' => 'You do not have access to this tenant.',
            ], 403);
        }

        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
