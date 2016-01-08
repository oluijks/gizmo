<?php

namespace Gizmo\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Generates a command.
 *
 * @author  Olaf Luijks
 */
class MakeCommand extends Command
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

        $this->setName('gizmo:make-command')
             ->setDescription($this->messages->translator->trans('make.command.desc'))
             ->addArgument('name', InputArgument::REQUIRED, $this->messages->translator->trans('make.command.arg'));
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
        $output->writeln('<info>Not implemented yet</info>');
        $output->writeln('');
    }

    /**
     * Get the stub file for the vhost.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/command.stub';
    }
}
