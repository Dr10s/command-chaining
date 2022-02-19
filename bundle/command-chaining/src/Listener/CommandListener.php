<?php

namespace Dr10s\CommandChaining\Listener;

use Dr10s\CommandChaining\Chain\CommandChain;
use Error;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class CommandListener
{
    public function __construct(private CommandChain $chain)
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
    }

    public function onConsoleTerminate(ConsoleEvent $event): void
    {
        /** @var Command $command */
        $command = $event->getCommand();

        if ($this->chain->isChain($command)) {
            foreach ($this->chain->getChainItems($command) as $item) {
                if ($item instanceof Command) {
                    $item->run(new ArrayInput([]), new ConsoleOutput());
                }
            }
        }
    }
}
