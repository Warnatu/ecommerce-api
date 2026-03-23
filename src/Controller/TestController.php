<?php

namespace App\Controller;

use App\Service\TestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    private TestService $testService;

    // Symfony inyecta automáticamente el servicio
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    #[Route('/test', name: 'test')]
    public function index(): JsonResponse
    {
        // Llamamos al service
        $data = $this->testService->getData();

        // Retornamos JSON
        return new JsonResponse($data);
    }
}