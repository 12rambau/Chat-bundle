<?php

namespace Btba\ChatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('btba_chat');
        //$rootNode = $treeBuilder->root('btba_chat');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('update_interval')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('message_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('author_class')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;

    }
}