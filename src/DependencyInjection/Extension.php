<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class Extension extends SymfonyExtension
{
    public function getAlias(): string
    {
        return 'doctrine_utils';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (false === $config['enabled']) {
            return;
        }

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/Config')
        );

        $loader->load('factory.xml');
        $loader->load('generator.xml');
    }
}