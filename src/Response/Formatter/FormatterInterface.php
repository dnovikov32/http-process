<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Formatter;

use App\ProcessBundle\Response\ResponseInterface;

interface FormatterInterface
{
    public function format(ResponseInterface $response): ResponseInterface;
}
