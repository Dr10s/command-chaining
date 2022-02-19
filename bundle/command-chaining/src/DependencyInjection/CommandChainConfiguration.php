<?php

namespace Dr10s\CommandChaining\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class CommandChainConfiguration implements ConfigurationInterface
{
    public function __construct(private string $alias)
    { }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder($this->alias);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->addDefaultsIfNotSet();

        return $treeBuilder;
    }
}
