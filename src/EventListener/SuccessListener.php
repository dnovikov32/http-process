<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\EventListener;

use League\Pipeline\PipelineInterface;
use Dnovikov32\HttpProcess\Response\ResponseInterface;
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
