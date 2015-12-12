<?php

namespace Gizmo\Console\Commands\Webserver\Nginx;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Restart the nginx engine
 *
 * @author  Olaf Luijks
 * @todo    catch errors from exec output
 */
class RestartNginxCommand extends Command
{
    protected function configure()
    {
        $this->setName('nginx:restart')
             ->setDescription('Restarts the nginx webserver');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('sudo service nginx restart 2>&1', $retArr, $retVal);

        $output->writeln('');
        $output->writeln('<info>' . PHP_EOL . $retArr[0] .'</info>');

        $o = exec('sudo service nginx status 2>&1');

        $output->writeln('<comment>' . PHP_EOL . $o . PHP_EOL . '</comment>');
        $output->writeln('');
    }
}
