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
class ShowDatabasesCommand extends Command
{
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

        // Setup table headers and rows
        if ($input->getOption('with-default-collation'))
            $headers = ['SCHEMA_NAME', 'DEFAULT_COLLATION_NAME'];
        else
            $headers = ['SCHEMA_NAME'];

        $rows = $this->getDatabases($input, $username, $password);

        $table = new Table($output);
        $table->setHeaders($headers)->setRows($rows)->render();
    }

    protected function getDatabases($input, $username, $password)
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'INFORMATION_SCHEMA',
            'username'  => $username,
            'password'  => $password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $query = 'SELECT SCHEMA_NAME, DEFAULT_COLLATION_NAME FROM INFORMATION_SCHEMA.SCHEMATA ORDER BY SCHEMA_NAME';

        $dbs = Capsule::select($query);

        $rows = [];

        for ($i = 0; $i < count($dbs); $i++) {
            $rows[$i][] = $dbs[$i]->SCHEMA_NAME;
            if ($input->getOption('with-default-collation'))
                $rows[$i][] = $dbs[$i]->DEFAULT_COLLATION_NAME;
        }

        return $rows;
    }
}
