<?php

namespace Dr10s\CommandChaining\Listener;

use Dr10s\CommandChaining\Chain\CommandChain;
use Error;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class CommandListener
{
    public function __construct(private CommandChain $chain, private LoggerInterface $logger)
    {
    }

    public function onConsoleCommand(ConsoleEvent $event): void
    {
        /** @var Command $command */
        $command = $event->getCommand();

        if ($chain = $this->chain->findPartOfChain($command)) {
            throw new Error(
                sprintf(
                    '%s command is a member of %s command chain and cannot be executed on its own.',
                    $command->getName(),
                    $chain
                )
            );
        }

        if ($this->chain->isChain($command)) {
            $this->logger->debug(
                sprintf(
                    '%s is a master command of a command chain that has registered member commands',
                    $command->getName()
                )
            );

            foreach ($this->chain->getChainItems($command) as $item) {
                $this->logger->debug(
                    sprintf(
                        '%s registered as a member of %s command chain',
                        $item->getName(),
                        $command->getName()
                    )
                );
            }

            $this->logger->debug(sprintf('Executing %s command itself first:', $command->getName()));
        }
    }

    public function onConsoleTerminate(ConsoleEvent $event): void
    {
        /** @var Command $command */
        $command = $event->getCommand();

        if ($this->chain->isChain($command)) {
            $this->logger->debug(sprintf('Executing %s chain members:', $command->getName()));

            foreach ($this->chain->getChainItems($command) as $item) {
                if ($item instanceof Command) {
                    $item->run(new ArrayInput([]), new ConsoleOutput());
                }
            }

            $this->logger->debug(sprintf('Executing %s chain completed.', $command->getName()));
        }
    }
}
