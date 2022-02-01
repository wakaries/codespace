<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CodespaceBlogInitCommand extends Command
{
    protected static $defaultName = 'codespace:blog:init';
    protected static $defaultDescription = 'Add a short description for your command';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('OK');

        return Command::SUCCESS;
    }
}
