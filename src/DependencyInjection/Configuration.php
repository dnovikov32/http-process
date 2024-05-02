<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcess\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Throwable;

final class Configuration implements ConfigurationInterface
{
    private const DEFAULT_PRIORITY = 10;

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('process');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->
            children()
                ->append($this->getDefaultNode())
                ->append($this->getSuccessNode())
                ->append($this->getGroupsNode())
            ->end();

        return $treeBuilder;
    }

    private function getDefaultNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('default');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('pipeline')
                    ->defaultValue('process.pipeline.default')
                ->end()
                ->integerNode('priority')
                    ->defaultValue(self::DEFAULT_PRIORITY)
                ->end()
            ->end();

        return $rootNode;
    }

    private function getSuccessNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('success');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('pipeline')
                ->end()
            ->end();

        return $rootNode;
    }

    private function getGroupsNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('groups');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->useAttributeAsKey('name')
            ->prototype('array')
                ->children()
                    ->scalarNode('response')->end()
                    ->scalarNode('pipeline')->end()
                    ->integerNode('priority')->end()
                    ->arrayNode('exceptions')
                        ->prototype('scalar')->end()
                        ->validate()
                            ->ifArray()
                            ->then(function (array $items) {
                                foreach ($items as $class) {
                                    $this->testExceptionExists($class);
                                }

                                return $items;
                            })
                        ->end()
                    ->end()
                ->end();

        return $rootNode;
    }

    private function testExceptionExists(string $exceptionClass): void
    {
        if (!is_subclass_of($exceptionClass, Throwable::class) &&
            !is_a($exceptionClass, Throwable::class, true)
        ) {
            throw new InvalidConfigurationException("Unable to load class '{$exceptionClass}' or class not implements '\\Throwable'.");
        }
    }
}
