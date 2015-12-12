<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Configure Gizmo
 *
 * @author  Olaf Luijks
 */
class ConfigCommand extends Command
{
    protected $version = 'v1.0.0';

    protected function configure()
    {
        $this->setName('config')
             ->setDescription('Configure Gizmo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<error>' . PHP_EOL . '  Not implemented yet' . PHP_EOL . '</error>');
        $output->writeln('');
    }
}
