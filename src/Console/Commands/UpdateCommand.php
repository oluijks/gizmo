<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Updates Gizmo to the latest version
 *
 * @author  Olaf Luijks
 */
class UpdateCommand extends Command
{
    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('update')
             ->setDescription('Updates Gizmo to the latest version');
    }

    /**
     * Execute the command
     *
     * @param  InputInterface   $input
     * @param  OutputInterface  $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<error>' . PHP_EOL . '  Not implemented yet' . PHP_EOL . '</error>');
        $output->writeln('');
    }
}
