<?php

namespace Dr10s\CommandChaining\Chain;

use Symfony\Component\Console\Command\Command;

class CommandChain
{
    /** @param Command[] */
    public function __construct(private array $chains = [])
    {
    }

    public function findPartOfChain(Command $command): ?string
    {
        foreach ($this->chains as $key => $chain) {
            foreach ($chain as $item) {
                if ($item->getName() === $command->getName()) {
                    return $key;
                }
            }
        }

        return null;
    }

    public function isChain(Command $command): bool
    {
        foreach ($this->chains as $key => $chain) {
            if ($key === $command->getName()) {
                return true;
            }
        }

        return false;
    }

    public function getChainItems(Command $command): array
    {
        return $this->chains[$command->getName()];
    }
}
