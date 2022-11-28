<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\Kernel;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TheCodingMachine\GraphQLite\Schema;
use TheCodingMachine\GraphQLite\SchemaFactory;

/**
 * Factory to create request handlers.
 *
 * A request handler is used to handle request for a specific API endpoint.
 */
class RequestHandlerFactory
{
    public function __construct(
      private readonly ContainerInterface $container
    ) {
    }

    public function createRequestHandler(CacheItemPoolInterface $cache, string $resolvers, string $types): RequestHandler
    {
        $schema = $this->createSchema(
            $cache,
            $resolvers,
            $types,
        );

        return new RequestHandler(
            $schema,
            $this->isDevelopmentEnvironment(),
        );
    }

    private function createSchema(CacheItemPoolInterface $cache, string $resolvers, string $types): Schema
    {
        $psrCache = new Psr16Cache($cache);

        $factory = (new SchemaFactory($psrCache, $this->container))
            ->addControllerNamespace($resolvers)
            ->addTypeNamespace($types);

        if ($this->isDevelopmentEnvironment()) {
            $factory->devMode();
        } else {
            $factory->prodMode();
        }

        return $factory->createSchema();
    }

    private function isDevelopmentEnvironment(): bool
    {
        /** @var Kernel $kernel */
        $kernel = $this->container->get('kernel');

        return $kernel->getEnvironment() === 'dev';
    }
}
