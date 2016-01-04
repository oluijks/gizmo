<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * About command.
 *
 * @author  Olaf Luijks
 */
class AboutCommand extends Command
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->setName('gizmo:about')
             ->setDescription('Short information about Gizmo');
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
        $output->writeln('<info>'.PHP_EOL.'  Gizmo - Console Application (Rohecom)</info>');
        $output->writeln('<info>  =====================================</info>');
        $output->writeln('<comment>'.PHP_EOL.'  A collection of tools to manage mysql, nginx and php</comment>');
        $output->writeln('');
    }
}
