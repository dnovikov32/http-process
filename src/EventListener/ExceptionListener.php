<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\EventListener;

use League\Pipeline\PipelineInterface;
use Dnovikov32\HttpProcessBundle\Response\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

final class ExceptionListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @param class-string[] $exceptions
     */
    public function __construct(
        private readonly ResponseInterface $response,
        private readonly PipelineInterface $pipeline,
        LoggerInterface $logger,
        private readonly array $exceptions
    ) {
        $this->setLogger($logger);
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($this->canHandleEvent($event)) {
            $this->logger->debug($event->getThrowable());
            $this->response->setException($event->getThrowable());
            $event->setResponse(($this->pipeline)($this->response));
        }
    }

    private function canHandleEvent(ExceptionEvent $event): bool
    {
        $exception = $event->getThrowable();

        return !$event->hasResponse() && $this->isThrown($exception);
    }

    private function isThrown(Throwable $exception): bool
    {
        foreach ($this->exceptions as $exceptionClass) {
            if ($exception instanceof $exceptionClass) {
                return true;
            }
        }

        return false;
    }
}
