<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Stage;

use App\ProcessBundle\Response\ResponseInterface;
use League\Pipeline\StageInterface;
use App\ProcessBundle\Response\Transformer\ResponseTransformerInterface;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class CreateResponse implements StageInterface
{
    public function __construct(
        private readonly ResponseTransformerInterface $transformer
    ) {
    }

    /**
     * @param ResponseInterface $payload
     */
    public function __invoke(mixed $payload): HttpResponse
    {
        return $this->transformer->transform($payload);
    }
}
