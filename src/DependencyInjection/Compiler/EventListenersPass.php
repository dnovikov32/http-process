<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\DependencyInjection\Compiler;

use Dnovikov32\HttpProcess\EventListener\ExceptionListener;
use Dnovikov32\HttpProcess\EventListener\SuccessListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class EventListenersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->successListenerPass($container);

        if ($container->hasParameter('process.groups')) {
            $this->exceptionListenersPass($container);
        }
    }

    private function successListenerPass(ContainerBuilder $container): void
    {
        $successConfig = $container->getParameter('process.pipeline.success');
        $pipelineDefinition = $container->findDefinition($successConfig['pipeline']);

        $successListenerDefinition = new Definition(SuccessListener::class, [$pipelineDefinition]);
        $successListenerDefinition
            ->setPublic(true)
            ->addTag('kernel.event_listener', ['event' => 'kernel.view']);

        $container->setDefinition('process.success_listener', $successListenerDefinition);
    }

    private function exceptionListenersPass(ContainerBuilder $container): void
    {
        $groups = $container->getParameter('process.groups');

        foreach ($groups as $name => $group) {
            $exceptionListener = $this->createExceptionListener($group, $group['exceptions'], $container);
            $container->setDefinition(sprintf('process.%s_listener', $name), $exceptionListener);
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
