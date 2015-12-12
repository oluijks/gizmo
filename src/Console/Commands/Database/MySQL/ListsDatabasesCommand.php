<?php

namespace Gizmo\Console\Commands\Database\MySQL;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Question\Question;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Shows a table with database names
 *
 * @author  Olaf Luijks
 */
class ListsDatabasesCommand extends Command
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * Configure the command options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('db:list')
             ->setDescription('Lists MySQL databases')
             ->addOption(
                'with-default-collation',
                null,
                InputOption::VALUE_NONE,
                'Show the databases default collation names'
             );
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
        $output->writeln('');

        // Ask the user for database credentials
        $this->askCredentials($input, $output);

        $collation = $input->getOption('with-default-collation');

        // Setup table headers and rows
        if ($collation)
            $headers = ['SCHEMA_NAME', 'DEFAULT_COLLATION_NAME'];
        else
            $headers = ['SCHEMA_NAME'];

        $rows = $this->getDatabases($input, $username, $password, $collation);

        $table = new Table($output);
        $output->writeln('');
        $table->setHeaders($headers)->setRows($rows)->render();
        $output->writeln('');
    }

    /**
     * Execute the command
     *
     * @param  InputInterface   $input
     * @param  username         $username
     * @param  password         $password
     * @param  collation        $collation
     * @return $rows            mixed
     */
    protected function getDatabases($input, $username, $password, $collation)
    {
        $this->connect();

        $tables = 'SCHEMA_NAME';
        if ($collation)
            $tables .= ', DEFAULT_COLLATION_NAME';

        $query = '
            SELECT ' . $tables . '
            FROM INFORMATION_SCHEMA.SCHEMATA
            ORDER BY SCHEMA_NAME';

        $dbs = Capsule::select($query);

        $rows = [];

        for ($i = 0; $i < count($dbs); $i++) {
            $rows[$i][] = $dbs[$i]->SCHEMA_NAME;
            if ($collation)
                $rows[$i][] = $dbs[$i]->DEFAULT_COLLATION_NAME;
        }

        return $rows;
    }

    /**
     * Connects to the database
     *
     * @return void
     */
    private function connect()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'INFORMATION_SCHEMA',
            'username'  => $this->username,
            'password'  => $this->password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Asks the use for database credentials
     *
     * @return void
     */
    private function askCredentials($input, $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Username: ');
        $this->username = $helper->ask($input, $output, $question);

        $question = new Question('Password: ');
        $question->setHidden(true);
        $question->setHiddenFallback(false);
        $this->password = $helper->ask($input, $output, $question);
    }
}
