<?php

namespace Gizmo\Console\Commands\Webserver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Helper\TableCell;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Shows some process statuses and server info.
 *
 * @author  Olaf Luijks
 */
class WebserverStatusCommand extends Command
{
    /**
     * @var Symfony\Component\Translation\Translator
     */
    private $messages;

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->messages = new Messages();

        $this->setName('webserver:status')
             ->setDescription($this->messages->translator->trans('webserver.webserver.status.command.desc'));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('uptime -p 2>&1', $uptime, $uptimeretVal);
        exec('sudo service mysql status 2>&1', $mySqlretArr, $mySqlretVal);
        exec('sudo service nginx status 2>&1', $nginxretArr, $nginxretVal);
        exec('sudo service php5-fpm status 2>&1', $php5fpmretArr, $php5fpmretVal);

        $table = new Table($output);
        $table
            ->setHeaders([
                [new TableCell('Server '.exec('hostname'), ['colspan' => 2])],
                [$this->messages->translator->trans('webserver.webserver.status.process'), $this->messages->translator->trans('webserver.webserver.status.status')],
            ])
            ->setRows([
                [$this->messages->translator->trans('webserver.webserver.status.mysql'), $mySqlretArr[0]],
                [$this->messages->translator->trans('webserver.webserver.status.nginx'), ltrim($nginxretArr[0], ' ')],
                [$this->messages->translator->trans('webserver.webserver.status.php5'), $php5fpmretArr[0]],
                new TableSeparator(),
                [new TableCell($this->messages->translator->trans('webserver.webserver.status.uptime', ['%uptime%' => $uptime[0]]), ['colspan' => 2])],
            ])
        ;
        $table->render();
    }
}
