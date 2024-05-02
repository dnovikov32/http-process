<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\Controller;

use Dnovikov32\HttpProcess\Response\ResponseInterface;
use League\Pipeline\PipelineInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class Controller extends AbstractController
{
    public function __construct(
        readonly private PipelineInterface $pipeline
    ) {
    }

    public function index(Request $httpRequest): ResponseInterface
    {
        return $this->pipeline->process($httpRequest);
    }
}
