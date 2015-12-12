<?php

namespace Gizmo\Console\Commands\Server;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;

/**
 * Shows some process statuses and server info
 *
 * @author  Olaf Luijks
 */
class ServerHealthCheckCommand extends Command
{
    protected function configure()
    {
        $this->setName('server:health')
             ->setDescription('Shows the server health');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('uptime -p 2>&1', $retArr, $retVal);
        exec('sudo service mysql status 2>&1', $mySqlretArr, $retVal);
        exec('sudo service nginx status 2>&1', $nginxretArr, $retVal);
        exec('sudo service php5-fpm status 2>&1', $php5fpmretArr, $retVal);

        $table = new Table($output);
        $table
            ->setHeaders([
                [new TableCell('Server ' . exec('hostname'), ['colspan' => 2])],
                ['PROCESS', 'STATUS'],
            ])
            ->setRows([
                ['mysql database engine', $mySqlretArr[0]],
                ['nginx', ltrim($nginxretArr[0], ' ')],
                ['php-fpm', $php5fpmretArr[0]],
                new TableSeparator(),
                [new TableCell('Server is ' . $retArr[0], ['colspan' => 2])],
            ])
        ;
        $table->render();
    }
}
