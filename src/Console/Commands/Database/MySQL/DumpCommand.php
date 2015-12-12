<?php

namespace Gizmo\Console\Commands\Database\MySQL;

error_reporting(0);

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use Ifsnop\Mysqldump as IMysqldump;

/**
 * Dumps a given database to a given location
 *
 * @author  Olaf Luijks
 * @see https://github.com/ifsnop/mysqldump-php
 */
class DumpCommand extends Command
{
    protected $version = 'v1.0.0';

    protected function configure()
    {
        $this->setName('db:dump')
             ->setDescription('Dumps structure and contents of MySQL database and tables')
             ->addArgument(
                 'name',
                 InputArgument::REQUIRED,
                 'The name of the database to dump'
             )
             ->addOption('dump-dir', null, InputOption::VALUE_OPTIONAL, 'The location of the database dump')
             ->addOption('compress', 'bzip2|gzip', InputOption::VALUE_OPTIONAL, 'Compress the database dump');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Ask the user for database credentials
        $helper = $this->getHelper('question');
        $question = new Question('Username: ');
        $username = $helper->ask($input, $output, $question);

        $question = new Question('Password: ');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $question);

        $name     = $input->getArgument('name');
        $compress = $input->getOption('compress');
        $dir      = $input->getOption('dump-dir');

        if (! $dir) $dir = getcwd() . '/dumps';

        $fileName = $dir . '/' . $name . '-' . date('Y-m-d') . '-' . time() . '.sql';

        $dumpSettings = ['compress' => IMysqldump\Mysqldump::NONE];
        $dumpSettings = ['skip-comments' => false];

        if ('gzip' === $compress) {
            $dumpSettings = ['compress' => IMysqldump\Mysqldump::GZIP];
            $fileName .= '.gz';
        }
        elseif ('bzip2' === $compress)
        {
            $dumpSettings = ['compress' => IMysqldump\Mysqldump::BZIP2];
            $fileName .= '.bz2';
        }

        // Create the database dump
        try
        {
            $output->writeln('');
            $output->writeln('<comment>  Dumping database '.$name.' to \''.$dir.'\'... </comment>');
            $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=' . $name, $username, $password, $dumpSettings);
            $dump->start($fileName);
        }
        catch (\Exception $e)
        {
            $output->writeln('');
            $output->writeln('<error> ' . PHP_EOL . '  Error: ' . $e->getMessage() . PHP_EOL . '</error>');
            $output->writeln('');
            exit(-1);
        }

        $output->writeln('');
        $output->writeln('<info>' . PHP_EOL . '  All Done!' . PHP_EOL . '</info>');
        $output->writeln('');
    }
}
