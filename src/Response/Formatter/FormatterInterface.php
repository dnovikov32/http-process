<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Response\Formatter;

use Dnovikov32\HttpProcessBundle\Response\ResponseInterface;

interface FormatterInterface
{
    public function format(ResponseInterface $response): ResponseInterface;
}
