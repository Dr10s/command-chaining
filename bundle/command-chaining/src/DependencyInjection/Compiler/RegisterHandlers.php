<?php

namespace Dr10s\CommandChaining\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterHandlers implements CompilerPassInterface
{
    use CollectServices;

    public function __construct(
        private string $serviceLocatorId,
        private string $tag,
        private $keyAttribute
    ) {
    }

    /**
     * Search for message handler services and provide them as a constructor argument to the message handler map
     * service.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has($this->serviceLocatorId)) {
            return;
        }

        $serviceLocatorDefinition = $container->findDefinition($this->serviceLocatorId);

        $handlers = [];
        $services = [];

        $this->collectServiceIds(
            $container,
            $this->tag,
            $this->keyAttribute,
            function ($key, $serviceId, array $tagAttributes) use (&$handlers, &$services) {
                $handlers[$serviceId][] = new Reference(ltrim($key, '\\'));
                $services[ltrim($key, '\\')] = new Reference($serviceId);
            }
        );

        $serviceLocatorDefinition->replaceArgument(0, $handlers);
    }
}
