<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * About command
 *
 * @author  Olaf Luijks
 */
class AboutCommand extends Command
{
    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('gizmo:about')
             ->setDescription('Short information about Gizmo');
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
        $output->writeln('<info>' . PHP_EOL . '  Gizmo - Console Application</info>');
        $output->writeln('<info>  ===========================</info>');
        $output->writeln('<comment>' . PHP_EOL . '  A collection of tools to manage mysql, nginx and php</comment>');
        $output->writeln('');
    }

    /**
     * Sets the aliases for the command.
     *
     * @param array $aliases An array of aliases for the command
     *
     * @return Command The current instance
     *
     * @api
     */
     public function setAliases($aliases)
     {
         return ['x'];
     }
}
