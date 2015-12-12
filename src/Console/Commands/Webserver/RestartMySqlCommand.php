<?php

namespace Gizmo\Console\Commands\Webserver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Restart the mysql engine
 *
 * @author  Olaf Luijks
 * @todo    catch errors from exec output
 */
class RestartMySqlCommand extends Command
{
    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('webserver:mysql:restart')
             ->setDescription('Restarts MySQL');
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
        exec('sudo service mysql restart 2>&1', $retArr, $retVal);

        $output->writeln('');
        $output->writeln('<info>' . PHP_EOL . ' ' . $retArr[0] .'</info>');

        $o = exec('sudo service mysql status 2>&1');

        $output->writeln('<comment>' . PHP_EOL . ' ' . $o . PHP_EOL . '</comment>');
        $output->writeln('');
    }
}
