# Gizmo
Gizmo Console Application.

Just a collection of tools I use on a daily basis. Feel free to fork me or drop me a message if you are missing some command you want me to add.

Email: <oluijks@gmail.com>

## License

Gizmo is open-sourced software licensed under the MIT license.

## Stuff used to make this
* Symfony Console Component (https://github.com/symfony/console)
* Symfony Process Component (https://github.com/symfony/process)
* Symfony Filesystem Component (https://github.com/symfony/filesystem)
* Illuminate Database (https://github.com/illuminate/database)
* MySQLDump - PHP (https://github.com/ifsnop/mysqldump-php)
* Guzzle, an extensible PHP HTTP client (https://github.com/guzzle/guzzle)
* Phar Update (https://github.com/kherge-abandoned/php-phar-update)

### Help

    Gizmo Console Application version 1.0.8

    Usage:
      command [options] [arguments]

    Options:
      -h, --help            Display this help message
      -q, --quiet           Do not output any message
      -V, --version         Display this application version
          --ansi            Force ANSI output
          --no-ansi         Disable ANSI output
      -n, --no-interaction  Do not ask any interactive question
      -v|vv|vvv, --verbose  Increase the verbosity of messages:
                            1 for normal output, 2 for more verbose output and 3 for debug

    Available commands:
      help                        Displays help for a command
      list                        Lists commands
     db
      db:dump                     Dumps a MySQL database
      db:list                     Lists MySQL databases
     download
      download:magento2           Grabs the latest magento2 source
      download:wordpress          Grabs the latest wordpress source
     gizmo
      gizmo:make-command          Makes a new gizmo command
      gizmo:update                Updates gizmo.phar to the latest version
     webserver
      webserver:make-nginx-vhost  Makes a new nginx vhost file
      webserver:mysql:restart     Restarts MySQL
      webserver:nginx:restart     Restarts Engine-X
      webserver:php5-fpm:restart  Restarts PHP5-FPM
      webserver:status            Webserver status
