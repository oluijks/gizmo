<?php

namespace Gizmo\Console\Commands\Webserver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Restart the mysql engine.
 *
 * @author  Olaf Luijks
 *
 * @todo    catch errors from exec output
 */
class RestartMySqlCommand extends Command
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

        $this->setName('webserver:mysql:restart')
             ->setDescription($this->messages->translator->trans('webserver.restart.mysql.command.desc'));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        exec('sudo service mysql restart 2>&1', $retArr, $retVal);

        $output->writeln('');
        $output->writeln('<info>'.$retArr[0].'</info>');

        $o = exec('sudo service mysql status 2>&1');

        $output->writeln('<comment>'.$o.'</comment>');
        $output->writeln('');
    }
}
