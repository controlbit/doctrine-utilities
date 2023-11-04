<?php
declare(strict_types=1);

namespace ControlBit\DoctrineUtils\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('doctrine_utils');

        /**
         * @phpstan-ignore-next-line
         */
        $treeBuilder
            ->getRootNode()
                ->children()
                    ->booleanNode('enabled')
                        ->info('Setting bundle OFF. Probably for debugging purposes.')
                        ->defaultTrue()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}