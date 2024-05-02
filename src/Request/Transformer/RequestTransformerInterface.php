<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\Request\Transformer;

use Dnovikov32\HttpProcessBundle\Request\ApiRequestInterface;
use Symfony\Component\HttpFoundation\Request;

interface RequestTransformerInterface
{
    public function transform(Request $request): ApiRequestInterface;
}
