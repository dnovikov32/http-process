<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess;

use Dnovikov32\HttpProcess\DependencyInjection\Compiler\EventListenersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class HttpProcessBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new EventListenersPass());
    }
}
