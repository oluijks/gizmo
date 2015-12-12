<?php

namespace Gizmo\Console\Commands;

use Herrera\Phar\Update\Manager;
use Herrera\Phar\Update\Manifest;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Updates Gizmo to the latest version
 *
 * @author  Olaf Luijks
 */
class UpdateCommand extends Command
{
    const MANIFEST_FILE = 'http://oluijks.github.io/gizmo/downloads/manifest.json';

    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('update')
             ->setDescription('Updates gizmo.phar to the latest version');
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
        $manager = new Manager(Manifest::loadFile(self::MANIFEST_FILE));
        $manager->update($this->getApplication()->getVersion(), true);

        $output->writeln('');
        $output->writeln('<info>' . PHP_EOL . '  Gizmo updated' . PHP_EOL . '</info>');
        $output->writeln('');
    }
}
