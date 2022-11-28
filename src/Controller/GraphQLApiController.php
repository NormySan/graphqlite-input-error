<?php

declare(strict_types=1);

namespace App\Controller;

use App\GraphQL\ExplorerRenderer;
use App\GraphQL\RequestHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GraphQLApiController
{
    public function __construct(
        private readonly ExplorerRenderer $explorerRenderer,
        private readonly RequestHandler $requestHandler,
    ) {
    }

    #[Route('/', methods: ['POST'])]
    public function dashboard(Request $request): JsonResponse
    {
        return $this->requestHandler->handle($request);
    }

    #[Route('/', methods: ['GET'])]
    public function explorer(): Response
    {
        return $this->explorerRenderer->render('API');
    }
}
