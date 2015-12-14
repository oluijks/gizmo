<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates a command.
 *
 * @author  Olaf Luijks
 */
class MakeCommand extends Command
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->setName('gizmo:make-command')
             ->setDescription('Makes a new gizmo command')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the command');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<info>'.PHP_EOL.'  Not implemented yet'.PHP_EOL.'</info>');
        $output->writeln('');
    }
}
