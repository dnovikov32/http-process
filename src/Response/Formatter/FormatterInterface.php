<?php

declare(strict_types=1);

namespace HttpProcess\Response\Formatter;

use HttpProcess\Response\ResponseInterface;

interface FormatterInterface
{
    public function format(ResponseInterface $response): ResponseInterface;
}
