<?php

declare(strict_types=1);

namespace HttpProcess\Request\Transformer;

use HttpProcess\Request\ApiRequestInterface;
use Symfony\Component\HttpFoundation\Request;

interface RequestTransformerInterface
{
    public function transform(Request $request): ApiRequestInterface;
}
