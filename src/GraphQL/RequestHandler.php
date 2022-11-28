<?php

declare(strict_types=1);

namespace App\GraphQL;

use GraphQL\Error\DebugFlag;
use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TheCodingMachine\GraphQLite\Context\Context;
use TheCodingMachine\GraphQLite\Schema;

/**
 * Handles request to a GraphQL API endpoint.
 */
class RequestHandler
{
    public function __construct(
        private readonly Schema $schema,
        private readonly bool $isDevelopment,
    ) {
    }

    public function handle(Request $request): JsonResponse
    {
        $server = $this->createServer($this->schema);

        $result = $server->executePsrRequest(
            $this->convertToPsrRequest($request)
        );

        $response = new JsonResponse($result);

        return $response;
    }

    private function createServer(Schema $schema): StandardServer
    {
        $config = ServerConfig::create()
            ->setSchema($schema)
            ->setContext(new Context());

        if ($this->isDevelopment) {
            $config->setDebugFlag(DebugFlag::INCLUDE_DEBUG_MESSAGE);
        }

        return new StandardServer($config);
    }

    /**
     * Convert a Symfony request to a PSR-7 compliant request.
     */
    private function convertToPsrRequest(Request $request): RequestInterface
    {
        $psr17factory = new Psr17Factory();

        $psrHttpFactory = new PsrHttpFactory(
            $psr17factory,
            $psr17factory,
            $psr17factory,
            $psr17factory
        );

        $psrRequest = $psrHttpFactory->createRequest($request);

        $shouldParseBody =
            strtoupper($request->getMethod()) === 'POST' &&
            empty($psrRequest->getParsedBody());

        if ($shouldParseBody) {
            $content = $psrRequest->getBody()->getContents();
            $parsedBody = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON received in POST body: ' . json_last_error_msg());
            }

            $psrRequest = $psrRequest->withParsedBody($parsedBody);
        }

        return $psrRequest;
    }
}
