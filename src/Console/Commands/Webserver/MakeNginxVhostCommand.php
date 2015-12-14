<?php

namespace Gizmo\Console\Commands\Webserver;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Generates a nginx vhost file.
 *
 * @author  Olaf Luijks
 */
class MakeNginxVhostCommand extends Command
{
    /**
     * Configure the command options.
     */
    protected function configure()
    {
        $this->setName('webserver:make-nginx-vhost')
             ->setDescription('Makes a new nginx vhost file')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the vhost file');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $content = file_get_contents($this->getStub());

        $name = $input->getArgument('name');

        $helper = $this->getHelper('question');

        $question = new Question('What is the document root: ');
        $root = $helper->ask($input, $output, $question);

        $question = new Question('What is the server name: ');
        $serverName = $helper->ask($input, $output, $question);

        if (!$root) {
            $root = '/usr/local/www/';
        }

        if ('/' !== substr($root, -1)) {
            $root .= '/';
        }

        if (!$serverName) {
            $serverName = $name;
        }

        $content = str_replace('$NAME$', $name, $content);
        $content = str_replace('$ROOT$', $root, $content);
        $content = str_replace('$SERVER_NAME$', $serverName, $content);

        $output->writeln('');

        print_r($content);

        $output->writeln('<comment>'.PHP_EOL.'  Copy this to /etc/nginx/sites-available/' . $name . PHP_EOL . '</comment>');
        $output->writeln('');
    }

    /**
     * Get the stub file for the vhost.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/nginx-vhost.stub';
    }
}
