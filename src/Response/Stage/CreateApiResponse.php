<?php

declare(strict_types=1);

namespace App\ProcessBundle\Response\Stage;

use League\Pipeline\StageInterface;
use App\ProcessBundle\Response\ApiResponseInterface;
use App\ProcessBundle\Response\ResponseInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class CreateApiResponse implements StageInterface
{
    public function __construct(
        readonly private NormalizerInterface $normalizer,
        readonly private ResponseInterface $response
    ) {
    }

    /**
     * @param ApiResponseInterface $apiResponse
     *
     * @throws ExceptionInterface
     */
    public function __invoke(mixed $apiResponse): ResponseInterface
    {
        $content = $this->normalizer->normalize($apiResponse);

        return $this->response->setContent($content);
    }
}
