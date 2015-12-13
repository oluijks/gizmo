<?php

namespace Gizmo\Console\Commands\Webserver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generates a nginx vhost file
 *
 * @author  Olaf Luijks
 */
class MakeNginxVhostCommand extends Command
{
    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('webserver:make-nginx-vhost')
             ->setDescription('Makes a new nginx vhost file')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the vhost file');
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
        $output->writeln('<info>' . PHP_EOL . '  Not implemented yet' . PHP_EOL . '</info>');
        $output->writeln('');
    }
}
