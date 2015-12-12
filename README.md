# gizmo
Gizmo Console Application

    [gizmo] ./gizmo

    Gizmo Console Application version 0.0.1

    Usage:
      command [options] [arguments]

    Options:
      -h, --help            Display this help message
      -q, --quiet           Do not output any message
      -V, --version         Display this application version
          --ansi            Force ANSI output
          --no-ansi         Disable ANSI output
      -n, --no-interaction  Do not ask any interactive question
      -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

    Available commands:
      config         Configure Gizmo
      help           Displays help for a command
      list           Lists commands
      update         Updates Gizmo to the latest version
     db
      db:dump        Dumps structure and contents of MySQL database and tables
      db:list        Lists MySQL databases
     nginx
      nginx:restart  Restarts the nginx webserver
     php5
      php5:restart   Restarts the FastCGI Process Manager
     server
      server:health  Shows the server health
