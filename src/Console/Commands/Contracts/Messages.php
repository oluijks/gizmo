<?php

namespace Gizmo\Console\Commands\Contracts;

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;

/**
 * Messages.
 *
 * @author  Olaf Luijks
 */
class Messages
{
    /**
     * @var Symfony\Component\Translation\Translator
     */
    public $translator;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->translator = new Translator('en_US', new MessageSelector());
        $this->translator->addLoader('array', new ArrayLoader());
        $this->translator->addResource('array', [
            'app.name' => '<info>Gizmo - Console Application</info>',
            'app.desc' => '<comment>A handy collection of tools to manage MySql,'.PHP_EOL.'Engine-X, PHP and other web development stuff.</comment>',
            'about.command.desc' => 'Short information about Gizmo',
            'make.command.desc' => 'Makes a new gizmo command',
            'make.command.arg' => 'The name of the command',
            'update.command.desc' => 'Updates gizmo.phar to the latest version',
            'update.command.was.updated' => '<info>Gizmo was updated to the latest version</info>',
            'update.command.already.updated' => '<info>You are already using Gizmo version %version%</info>',
            'db.username' => 'Username: ',
            'db.password' => 'Password: ',
            'db.dump.desc' => 'Dumps a MySQL database',
            'db.dump.arg' => 'The name of the database to dump',
            'db.dump.option.location' => 'The location of the database dump',
            'db.dump.option.compress' => 'Compress the database dump',
            'db.dump.option.location.error' => '<error>Error: Failed to create dump folder</error>',
            'db.dump.message.dumping.db' => '<comment>Dumping database to %fileName%</comment>',
            'db.dump.message.dumping.error' => '<error>Error: %errorMessage%</error>',
            'db.list.desc' => 'Lists MySQL databases',
            'db.list.option' => 'Show the databases default collation names',
            'db.list.db.credentials' => '<info>Your database credentials:</info>',
            'downloads.grabs.magento2' => 'Grabs the latest magento2 source',
            'downloads.downloading.magento2' => '<comment>Downloading Magento2...</comment>',
            'downloads.grabs.wordpress' => 'Grabs the latest wordpress source',
            'downloads.downloading.wordpress' => '<comment>Downloading Wordpress...</comment>',
            'webserver.nginx.vhost.command.desc' => 'Makes a new nginx vhost file',
            'webserver.nginx.vhost.arg' => 'The name of the vhost file',
            'webserver.nginx.vhost.docroot.location' => 'Where is the the document root located: ',
            'webserver.nginx.vhost.servername' => 'What is the server name: ',
            'webserver.nginx.vhost.copy.this' => '<comment>Copy this to /etc/nginx/sites-available/%name%</comment>',
            'webserver.restart.mysql.command.desc' => 'Restarts MySQL',
            'webserver.restart.nginx.command.desc' => 'Restarts Engine-X',
            'webserver.restart.php5.command.desc' => 'Restarts PHP5-FPM',
            'webserver.webserver.status.command.desc' => 'Webserver status',
            'webserver.webserver.status.process' => 'PROCESS',
            'webserver.webserver.status.status' => 'STATUS',
            'webserver.webserver.status.mysql' => 'MySQL database engine',
            'webserver.webserver.status.nginx' => 'Nginx webserver',
            'webserver.webserver.status.php5' => 'PHP5 FastCGI Process Manager',
            'webserver.webserver.status.uptime' => 'Server is %uptime%',
            'app.all.done' => '<info>All Done!</info>',
        ], 'en_US');
    }
}
