<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Response\Stage;

use Dnovikov32\HttpProcessBundle\Response\Formatter\FormatterInterface;
use League\Pipeline\StageInterface;
use Dnovikov32\HttpProcessBundle\Response\ResponseInterface;

final class FormatResponse implements StageInterface
{
    public function __construct(
        private readonly FormatterInterface $formatter
    ) {
    }

    /**
     * @param ResponseInterface $response
     */
    public function __invoke(mixed $response): ResponseInterface
    {
        return $this->formatter->format($response);
    }
}
