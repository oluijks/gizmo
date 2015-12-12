<?php

namespace Gizmo\Console\Commands\Webserver;

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
class WebserverStatusCommand extends Command
{
    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('webserver:status')
             ->setDescription('Webserver status');
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
        exec('uptime -p 2>&1', $uptimeretArr, $uptimeretVal);
        exec('sudo service mysql status 2>&1', $mySqlretArr, $mySqlretVal);
        exec('sudo service nginx status 2>&1', $nginxretArr, $nginxretVal);
        exec('sudo service php5-fpm status 2>&1', $php5fpmretArr, $php5fpmretVal);

        $table = new Table($output);
        $table
            ->setHeaders([
                [new TableCell('Server ' . exec('hostname'), ['colspan' => 2])],
                ['PROCESS', 'STATUS'],
            ])
            ->setRows([
                ['MySQL database engine', $mySqlretArr[0]],
                ['Nginx webserver', ltrim($nginxretArr[0], ' ')],
                ['PHP5 FastCGI Process Manager', $php5fpmretArr[0]],
                new TableSeparator(),
                [new TableCell('Server is ' . $uptimeretArr[0], ['colspan' => 2])],
            ])
        ;
        $table->render();
    }
}
