<?php

namespace Gizmo\Console\Commands\Downloads;

use ZipArchive;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Grab the lastest wordpress version.
 *
 * @author  Olaf Luijks
 */
class DownloadWordPressCommand extends Command
{
    /**
     * @var Symfony\Component\Translation\Translator
     */
    private $messages;

    /**
     * Location of the source.
     */
    const _SRC_URL = 'https://wordpress.org/latest.zip';

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->messages = new Messages();

        $this->setName('download:wordpress')
             ->setDescription($this->messages->translator->trans('downloads.grabs.wordpress'));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = getcwd();

        $output->writeln('');
        $output->writeln($this->messages->translator->trans('downloads.downloading.wordpress'));

        $this->download($zipFile = $this->makeFilename())
             ->extract($zipFile, $directory)
             ->cleanUp($zipFile);

        $output->writeln('');
        $output->writeln($this->messages->translator->trans('app.all.done'));
        $output->writeln('');
    }

    /**
     * Generate a random temporary filename.
     *
     * @return string
     */
    protected function makeFilename()
    {
        return getcwd().'/wordpress_'.md5(time().uniqid()).'.zip';
    }

    /**
     * Download the temporary Zip to the given file.
     *
     * @param string $zipFile
     *
     * @return $this
     */
    protected function download($zipFile)
    {
        $response = (new Client())->get(self::_SRC_URL);
        file_put_contents($zipFile, $response->getBody());

        return $this;
    }

    /**
     * Extract the zip file into the given directory.
     *
     * @param string $zipFile
     * @param string $directory
     *
     * @return $this
     */
    protected function extract($zipFile, $directory)
    {
        $archive = new ZipArchive();
        $archive->open($zipFile);
        $archive->extractTo($directory);
        $archive->close();

        return $this;
    }

    /**
     * Clean-up the Zip file.
     *
     * @param string $zipFile
     *
     * @return $this
     */
    protected function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);
        @unlink($zipFile);

        return $this;
    }
}
