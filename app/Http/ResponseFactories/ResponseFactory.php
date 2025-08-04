<?php

namespace App\Http\ResponseFactories;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseFactory
{
    public function paginatedResponse(LengthAwarePaginator $paginator, callable $map): JsonResponse
    {
        return response()->json([
            'data' => $paginator->map($map),
            'meta' => [
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }
}
