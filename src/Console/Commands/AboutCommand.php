<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * About command.
 *
 * @author  Olaf Luijks
 */
class AboutCommand extends Command
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

        $this->setName('gizmo:about')
             ->setDescription($this->messages->translator->trans('about.command.desc'));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln($this->messages->translator->trans('app.name'));
        $output->writeln('<info>===========================</info>');
        $output->writeln('');
        $output->writeln($this->messages->translator->trans('app.desc'));
        $output->writeln('');
    }
}
