<?php

declare(strict_types=1);

namespace HttpProcess\Response\Stage;

use HttpProcess\Response\Formatter\FormatterInterface;
use League\Pipeline\StageInterface;
use HttpProcess\Response\ResponseInterface;

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
