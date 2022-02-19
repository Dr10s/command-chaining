<?php

namespace Dr10s\App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MasterCommand extends Command
{
    protected static $defaultName = 'master';

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello i`m master of chain');

        return Command::SUCCESS;
    }

}
