<?php

namespace Dr10s\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChainCommand extends Command
{
    protected static $defaultName = 'chain';

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello i`m chain item');

        return Command::SUCCESS;
    }

}
