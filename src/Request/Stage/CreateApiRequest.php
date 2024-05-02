<?php

declare(strict_types=1);

namespace HttpProcess\Request\Stage;

use HttpProcess\Request\ApiRequestInterface;
use HttpProcess\Request\Transformer\RequestTransformerInterface;
use League\Pipeline\StageInterface;
use Symfony\Component\HttpFoundation\Request;

final class CreateApiRequest implements StageInterface
{
    public function __construct(
        readonly private RequestTransformerInterface $transformer
    ) {
    }

    /**
     * @param Request $request
     */
    public function __invoke(mixed $request): ApiRequestInterface
    {
        return $this->transformer->transform($request);
    }
}
