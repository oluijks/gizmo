<?php

namespace Gizmo\Console\Commands\Database\MySQL;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Question\Question;
use Illuminate\Database\Capsule\Manager as Capsule;
use Gizmo\Console\Commands\Contracts\Messages;

/**
 * Shows a table with database names.
 *
 * @author  Olaf Luijks
 */
class ListsDatabasesCommand extends Command
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

        $this->setName('db:list')
             ->setDescription($this->messages->translator->trans('db.list.desc'))
             ->addOption(
                'with-default-collation',
                null,
                InputOption::VALUE_NONE,
                $this->messages->translator->trans('db.list.option')
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

        $collation = $input->getOption('with-default-collation');

        // Setup table headers and rows
        if ($collation) {
            $headers = ['SCHEMA_NAME', 'DEFAULT_COLLATION_NAME'];
        } else {
            $headers = ['SCHEMA_NAME'];
        }

        $rows = $this->getDatabases(
            $input,
            $this->username,
            $this->password,
            $collation
        );

        $table = new Table($output);
        $output->writeln('');
        $table->setHeaders($headers)->setRows($rows)->render();
        $output->writeln('');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param username       $username
     * @param password       $password
     * @param collation      $collation
     *
     * @return $rows mixed
     */
    protected function getDatabases($input, $username, $password, $collation)
    {
        $this->connect();

        $tables = 'SCHEMA_NAME';
        if ($collation) {
            $tables .= ', DEFAULT_COLLATION_NAME';
        }

        $query = '
            SELECT '.$tables.'
            FROM INFORMATION_SCHEMA.SCHEMATA
            ORDER BY SCHEMA_NAME';

        $dbs = Capsule::select($query);

        $rows = [];

        for ($i = 0; $i < count($dbs); ++$i) {
            $rows[$i][] = $dbs[$i]->SCHEMA_NAME;
            if ($collation) {
                $rows[$i][] = $dbs[$i]->DEFAULT_COLLATION_NAME;
            }
        }

        return $rows;
    }

    /**
     * Connects to the database.
     */
    private function connect()
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'INFORMATION_SCHEMA',
            'username' => $this->username,
            'password' => $this->password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Asks the use for database credentials.
     */
    private function askCredentials($input, $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question(
            $this->messages->translator->trans('db.username')
        );
        $this->username = $helper->ask($input, $output, $question);

        $question = new Question(
            $this->messages->translator->trans('db.password')
        );
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $this->password = $helper->ask($input, $output, $question);
    }
}
