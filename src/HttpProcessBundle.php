<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle;

use Dnovikov32\HttpProcessBundle\DependencyInjection\Compiler\EventListenersPass;
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
