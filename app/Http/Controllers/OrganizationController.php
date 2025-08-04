<?php

namespace App\Http\Controllers;

use App\Http\ResponseFactories\OrganizationResponseFactory;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function __construct(
        private readonly OrganizationService $organizationService,
        private readonly OrganizationResponseFactory $organizationResponseFactory,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query->getInt('per_page', 20);
        $paginator = $this->organizationService->paginate($perPage);

        return $this->organizationResponseFactory->index($paginator);
    }

    public function show(int $id): JsonResponse
    {
        $organization = $this->organizationService->get($id);
        if ($organization === null) {
            return response()->json(status: 404);
        }

        return $this->organizationResponseFactory->show($organization);
    }
}
