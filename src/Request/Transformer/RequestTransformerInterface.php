<?php

declare(strict_types=1);

namespace App\ProcessBundle\Request\Transformer;

use App\ProcessBundle\Request\ApiRequestInterface;
use Symfony\Component\HttpFoundation\Request;

interface RequestTransformerInterface
{
    public function transform(Request $request): ApiRequestInterface;
}
