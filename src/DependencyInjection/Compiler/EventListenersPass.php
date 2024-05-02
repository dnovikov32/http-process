<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\DependencyInjection\Compiler;

use Dnovikov32\HttpProcessBundle\EventListener\ExceptionListener;
use Dnovikov32\HttpProcessBundle\EventListener\SuccessListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class EventListenersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->successListenerPass($container);

        if ($container->hasParameter('http_process.groups')) {
            $this->exceptionListenersPass($container);
        }
    }

    private function successListenerPass(ContainerBuilder $container): void
    {
        $successConfig = $container->getParameter('http_process.pipeline.success');
        $pipelineDefinition = $container->findDefinition($successConfig['pipeline']);

        $successListenerDefinition = new Definition(SuccessListener::class, [$pipelineDefinition]);
        $successListenerDefinition
            ->setPublic(true)
            ->addTag('kernel.event_listener', ['event' => 'kernel.view']);

        $container->setDefinition('http_process.success_listener', $successListenerDefinition);
    }

    private function exceptionListenersPass(ContainerBuilder $container): void
    {
        $groups = $container->getParameter('http_process.groups');

        foreach ($groups as $name => $group) {
            $exceptionListener = $this->createExceptionListener($group, $group['exceptions'], $container);
            $container->setDefinition(sprintf('http_process.%s_listener', $name), $exceptionListener);
        }
    }

    private function createExceptionListener(array $groupConfig, array $exceptions, ContainerBuilder $container): Definition
    {
        $responseDefinition = $container->findDefinition($groupConfig['response']);
        $pipelineDefinition = $container->findDefinition($groupConfig['pipeline']);
        $loggerReference = new Reference('logger');

        $exceptionListener = new Definition(
            ExceptionListener::class,
            [
                $responseDefinition,
                $pipelineDefinition,
                $loggerReference,
                $exceptions
            ]
        );

        $exceptionListener
            ->setPublic(true)
            ->addTag(
                'kernel.event_listener',
                [
                    'event' => 'kernel.exception',
                    'priority' => $groupConfig['priority']
                ]
            );

        return $exceptionListener;
    }
}
