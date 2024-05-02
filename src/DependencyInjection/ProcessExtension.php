<?php

declare(strict_types=1);

namespace Dnovikov32\HttpProcessBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

final class ProcessExtension extends Extension
{
    private const CONFIG_DIRECTORY = __DIR__ . '/../Resources/config';

    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $defaultConfig = Yaml::parse(file_get_contents(self::CONFIG_DIRECTORY . '/config.yml'));

        array_unshift($configs, $defaultConfig);

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('http_process.pipeline.default', $config['default']);

        $this->loadSuccess($config, $container);

        if (!empty($config['groups'])) {
            $this->loadGroups($config, $container);
        }

        $finder = (new Finder())->files()->notName('config.yml');
        $loader = new YamlFileLoader($container, new FileLocator(self::CONFIG_DIRECTORY));

        foreach ($finder->in(self::CONFIG_DIRECTORY) as $file) {
            $loader->load($file->getRealPath());
        }
    }

    private function loadSuccess(array $config, ContainerBuilder $container): void
    {
        $defaultConfig = $container->getParameter('http_process.pipeline.default');
        $defaultPipeline = $defaultConfig['pipeline'];

        if (!isset($config['success']['pipeline'])) {
            $config['success']['pipeline'] = $defaultPipeline;
        }

        $container->setParameter('http_process.pipeline.success', $config['success']);
    }

    private function loadGroups(array $config, ContainerBuilder $container): void
    {
        $defaultConfig = $container->getParameter('http_process.pipeline.default');
        $groups = [];

        foreach ($config['groups'] as $groupName => $group) {
            $group['pipeline'] = $group['pipeline'] ?? $defaultConfig['pipeline'];
            $group['priority'] = $group['priority'] ?? $defaultConfig['priority'];
            $groups[$groupName] = $group;
        }

        $container->setParameter('http_process.groups', $groups);
    }
}
