<?php

namespace App\Http\Controllers;

use App\Http\ResponseFactories\BuildingResponseFactory;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function __construct(
        private readonly BuildingService $buildingService,
        private readonly BuildingResponseFactory $buildingResponseFactory,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->getInt('per_page', 20);
        $paginator = $this->buildingService->paginate($perPage);

        return $this->buildingResponseFactory->index($paginator);
    }
}
