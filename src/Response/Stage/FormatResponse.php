<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Stage;

use App\ProcessBundle\Response\Formatter\FormatterInterface;
use League\Pipeline\StageInterface;
use App\ProcessBundle\Response\ResponseInterface;

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
