<?php

namespace Gizmo\Console\Commands;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Updates Gizmo to the latest version.
 *
 * @author  Olaf Luijks
 */
class UpdateCommand extends Command
{
    const MANIFEST_FILE = 'http://oluijks.github.io/gizmo/downloads/rohecom/manifest.json';

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->setName('gizmo:self-update')
             ->setDescription('Updates gizmo.phar to the latest version');
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
            $output->writeln('<info>'.PHP_EOL.'  Gizmo was updated to the latest version'.PHP_EOL.'</info>');
            $output->writeln('');
        } else {
            $output->writeln('');
            $output->writeln('<info>'.PHP_EOL.'  You are already using Gizmo version '.$this->getApplication()->getVersion().PHP_EOL.'</info>');
            $output->writeln('');
        }
    }
}
