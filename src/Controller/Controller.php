<?php

declare(strict_types=1);

namespace App\ProcessBundle\Controller;

use App\ProcessBundle\Response\ResponseInterface;
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
