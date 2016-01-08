<?php

namespace Gizmo\Console\Commands;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Updates Gizmo to the latest version.
 *
 * @author  Olaf Luijks
 */
class UpdateCommand extends Command
{
    const MANIFEST_FILE = 'http://oluijks.github.io/gizmo/downloads/rohecom/manifest.json';

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

        $this->setName('gizmo:self-update')
             ->setDescription($this->messages->translator->trans('update.command.desc'));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));

        if ($manager->update($this->getApplication()->getVersion(), true)) {
            $output->writeln('');
            $output->writeln($this->messages->translator->trans('update.command.was.updated'));
            $output->writeln('');
        } else {
            $output->writeln('');
            $output->writeln($this->messages->translator->trans('update.command.already.updated', ['version' => $this->getApplication()->getVersion()]));
            $output->writeln('');
        }
    }
}
