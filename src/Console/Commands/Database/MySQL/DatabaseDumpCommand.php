<?php

namespace Gizmo\Console\Commands\Database\MySQL;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Ifsnop\Mysqldump as IMysqldump;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Dumps a given database to a given location.
 *
 * @author  Olaf Luijks
 *
 * @see https://github.com/ifsnop/mysqldump-php
 */
class DatabaseDumpCommand extends Command
{
    /**
     * @var Symfony\Component\Translation\Translator
     */
    private $messages;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->messages = new Messages();

        $this->setName('db:dump')
             ->setDescription($this->messages->translator->trans('db.dump.desc'))
             ->addArgument(
                 'name',
                 InputArgument::REQUIRED,
                 $this->messages->translator->trans('db.dump.arg')
             )
             ->addOption(
                 'dump-dir',
                 null,
                 InputOption::VALUE_OPTIONAL,
                 $this->messages->translator->trans('db.dump.option.location')
             )
             ->addOption(
                 'compress',
                 'bzip2|gzip',
                 InputOption::VALUE_OPTIONAL,
                 $this->messages->translator->trans('db.dump.option.compress')
             );
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Ask the user for database credentials
        $output->writeln('');
        $output->writeln($this->messages->translator->trans('db.list.db.credentials'));
        $output->writeln('');
        $this->askCredentials($input, $output);

        // Get arguments and options
        $name = $input->getArgument('name');
        $compress = $input->getOption('compress');
        $dir = $input->getOption('dump-dir');

        // Create dumps dir if not exists
        if (!$dir) {
            $dir = getcwd().'/dumps';
            if (!is_dir($dir)) {
                if (!mkdir($dir, 01775)) {
                    $output->writeln(
                        $this->messages->translator->trans('db.dump.option.location.error')
                    );
                    $output->writeln('');
                    exit(-1);
                }
            }
        }

        $fileName = $dir.'/'.$name.'-'.date('Y-m-d').'-'.time().'.sql';

        // Dump settings
        $dumpSettings = ['compress' => IMysqldump\Mysqldump::NONE];
        $dumpSettings = ['skip-comments' => false];

        if ('gzip' === $compress) {
            $dumpSettings = ['compress' => IMysqldump\Mysqldump::GZIP];
            $fileName .= '.gz';
        } elseif ('bzip2' === $compress) {
            $dumpSettings = ['compress' => IMysqldump\Mysqldump::BZIP2];
            $fileName .= '.bz2';
        }

        // Try to create the database dump
        try {
            $output->writeln('');
            $output->writeln($this->messages->translator->trans('db.dump.message.dumping.db', ['%fileName%' => $fileName]));
            $dump = new IMysqldump\Mysqldump(
                'mysql:host=localhost;dbname='.$name,
                $this->username,
                $this->password, $dumpSettings
            );
            $dump->start($fileName);
            $output->writeln('');
        } catch (\Exception $e) {
            $output->writeln('');
            $output->writeln($this->messages->translator->trans('db.dump.message.dumping.error', ['errorMessage' => $e->getMessage()]));
            $output->writeln('');
            exit(-1);
        }

        $output->writeln($this->messages->translator->trans('app.all.done'));
        $output->writeln('');
    }

    /**
     * Asks the use for database credentials.
     */
    private function askCredentials($input, $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question($this->messages->translator->trans('db.username'));
        $this->username = $helper->ask($input, $output, $question);

        $question = new Question($this->messages->translator->trans('db.password'));
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $this->password = $helper->ask($input, $output, $question);
    }
}
