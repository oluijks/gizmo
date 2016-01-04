<?php

namespace Gizmo\Console\Commands\Downloads;

use ZipArchive;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Grab the lastest magento2 version.
 *
 * @author  Olaf Luijks
 */
class DownloadMagento2Command extends Command
{
    /**
     * Location of the source.
     */
    const _SRC_URL = 'https://github.com/magento/magento2/archive/develop.zip';

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->setName('download:magento2')
             ->setDescription('Grabs the latest magento2 source');
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
        $output->writeln('<comment>  Downloading Magento2...</comment>');

        $this->download($zipFile = $this->makeFilename())
             ->extract($zipFile, $directory)
             ->cleanUp($zipFile);

        $output->writeln('<info>'.PHP_EOL.'  All Done!'.PHP_EOL.'</info>');
    }

    /**
     * Generate a random temporary filename.
     *
     * @return string
     */
    protected function makeFilename()
    {
        return getcwd().'/magento2_'.md5(time().uniqid()).'.zip';
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
