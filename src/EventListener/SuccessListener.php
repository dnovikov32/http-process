<?php

declare(strict_types=1);

namespace App\ProcessBundle\EventListener;

use League\Pipeline\PipelineInterface;
use App\ProcessBundle\Response\ResponseInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;

final class SuccessListener
{
    public function __construct(
        private readonly PipelineInterface $pipeline
    ) {
    }

    public function onKernelView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();

        if ($result instanceof ResponseInterface) {
            $event->setResponse(($this->pipeline)($result));
        }
    }
}
