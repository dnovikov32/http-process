<?php

declare(strict_types=1);

namespace App\ProcessBundle\Request\Stage;

use App\ProcessBundle\Request\ApiRequestInterface;
use App\ProcessBundle\Request\Transformer\RequestTransformerInterface;
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
