# Gizmo
Gizmo Console Application

## Stuff used to make this
* Symfony Console Component (https://github.com/symfony/console)
* Symfony Process Component (https://github.com/symfony/process)
* Illuminate Database (https://github.com/illuminate/database)
* MySQLDump - PHP (https://github.com/ifsnop/mysqldump-php)

### Help

    Gizmo Console Application version 0.0.5

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
      config                      Configure Gizmo
      help                        Displays help for a command
      list                        Lists commands
      update                      Updates Gizmo to the latest version
     db
      db:dump                     Dumps structure and contents of MySQL database and tables
      db:list                     Lists MySQL databases
     webserver
      webserver:mysql:restart     Restarts MySQL
      webserver:nginx:restart     Restarts Engine-X
      webserver:php5-fpm:restart  Restarts PHP5-FPM
      webserver:status            Webserver status


## ./gizmo help db:dump

    [gizmo] ./gizmo help db:dump
      Usage:
        db:dump [options] [--] <name>

      Arguments:
        name                                The name of the database to dump

      Options:
            --dump-dir[=DUMP-DIR]           The location of the database dump

      Help:
       Dumps structure and contents of MySQL database and tables

    [gizmo] ./gizmo db:dump information_schema --dump-dir=/home/oluijks

       Username: root
       Password:

       Dumping database to /home/oluijks/information_schema-2015-12-12-1449933289.sql

       All Done!

## ./gizmo help db:Lists

    [gizmo] ./gizmo help db:dump
      Usage:
        db:list [options]

      Options:
            --with-default-collation  Show the databases default collation names

      Help:
       Lists MySQL databases

    [gizmo] ./gizmo db:list
      Username: root
      Password:

      +--------------------+
      | SCHEMA_NAME        |
      +--------------------+
      | information_schema |
      | mysql              |
      | performance_schema |
      +--------------------+

## ./gizmo webserver:mysql:restart

    Usage:
      webserver:mysql:restart

    Help:
     Restarts MySQL

    [gizmo] ./gizmo webserver:mysql:restart
     mysql stop/waiting

     mysql start/running, process 19395


## ./gizmo help webserver:nginx:restart

    Usage:
      webserver:nginx:restart

    Help:
     Restarts Engine-X

    [gizmo] ./gizmo webserver:nginx:restart
     * Restarting nginx nginx

     * nginx is running

## ./gizmo help webserver:php5-fpm:restart

    Usage:
      webserver:php5-fpm:restart

    Help:
     Restarts PHP5-FPM

    [gizmo] ./gizmo webserver:php5-fpm:restart
     php5-fpm stop/waiting

     php5-fpm start/running, process 19057

## ./gizmo help webserver:status

    Usage:
      webserver:status

    Help:
     Webserver status

     +------------------------------+--------------------------------------+
     | Server yoda                                                         |
     +------------------------------+--------------------------------------+
     | PROCESS                      | STATUS                               |
     +------------------------------+--------------------------------------+
     | MySQL database engine        | mysql start/running, process 1201    |
     | Nginx webserver              | * nginx is running                   |
     | PHP5 FastCGI Process Manager | php5-fpm start/running, process 7374 |
     +------------------------------+--------------------------------------+
     | Server is up 2 days, 17 hours, 33 minutes                           |
     +------------------------------+--------------------------------------+
