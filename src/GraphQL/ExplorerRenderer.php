<?php

declare(strict_types=1);

namespace App\GraphQL;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Renders the GraphQL explorer.
 */
class ExplorerRenderer
{
    public function __construct(
      private readonly Environment $twig
    ) {
    }

    /**
     * @param string $title The explorer page title.
     *
     * @throws LoaderError|RuntimeError|SyntaxError
     */
    public function render(string $title): Response
    {
        $content = $this->twig->render('explorer-apollo.html.twig', [
            'title' => $title,
        ]);

        return new Response($content);
    }
}
