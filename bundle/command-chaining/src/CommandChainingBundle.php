<?php

namespace Dr10s\CommandChaining;

use Dr10s\CommandChaining\DependencyInjection\CommandChainingExtension;
use Dr10s\CommandChaining\DependencyInjection\Compiler\RegisterHandlers;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CommandChainingBundle extends Bundle
{
    public function __construct()
    {
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(
            new RegisterHandlers(
                'command_chaining.command_chain',
                'chain_item',
                'item'
            )
        );
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CommandChainingExtension();
    }

}