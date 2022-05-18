# System requirements

- WEB Server with support for PHP5+ scripts
  The SIGVI has been developed and tested under Apache Web Server, version 2.

- PHP5+ command line interpreter (PHP 5 CLI)

- PHP5+ Soap module, for report generation

- Relational Database Management System
  One of these RDBMS: mysql (>4), oracle, postgres, but SIGVI scripts are
  developed for mysql. So if you use other, you will have a little extra work.

  The PHP module must support your RDBMS.

- For graphics support, the PHP module must include the GD library.

- The application is platform independent, but has been developed for UNIX, and
  preferably Linux.

- Is a good idea that your system is able to send emails.


# INSTALLATION PROCESS

Lets assume that your web home is /var/www. Else change for your needs.

1. Checking access and moving files

   # tar xzvf sigvi-2.9.1.tgz

   Move the sigvi web dir to your web server htdocs directory, for example:

   # mv sigvi /var/www/sigvi

   Give the sigvi web dir access to web server process. By default, if you use
   apache, it runs under "www-data" user. Check your configuration.

   # chown -R www-data:www-data /var/www/sigvi
   # chmod -R 750 /var/www/sigvi


2. Database creation

   Sigvi can works with many relational DB (see the include/dbms dir), but this
   sql file is exported from mysql. So if you want to use other type of RDBMS
   you will have to edit it manually. I'm sorry.

   Create the SIGVI database using the root user and the sql file deployed for
   the current version. For example, this is the sentence for the version 2.9.1:

   # echo "create database sigvi" | sudo mysql
   # echo "grant all privileges on sigvi.* to sigvi@localhost identified by 'sigvi05'" | sudo mysql sigvi
   # sudo mysql sigvi < sigvi-2.9.1.sql

3. Customizing the application to your environment

   Edit the conf/app.conf.php file and check for HOME, ADM_EMAIL, SERVER_URL,
   and the database configuration constants definition.

   Take care with the HOME constant.

     How to set the correct HOME value:

     Those are examples of the HOME definition, depending of the URL:

      - http://server.localdomain.domain/sigvi -->
        --> define("HOME","/sigvi");      IMPORTANT "/"

      - http://server.localdomain.domain/my_applications/sigvi_r2 -->
        --> define("HOME","/my_applications/sigvi_r2");

	  Example 2, If you have installed on a new virtual host:
      - http://server.localdomain.domain:81/ -->
        --> define("HOME","");            IMPORTANT NOT "/"


   Also, check LDAP configuration if you want to use it to validate your
   users.


4. Setting up the automatic vulnerability load and check process

   If you want automatic vulnerability load and automatic vulnerability you have
   to schedule those tasks.

   On UNIX systems, you have to add a crontab line to one crontab process. The
   process need to be executed under one user that can access to the web dir,
   for example www-data, or root.

      As root, edit the /etc/crontab file, and add the next line, changing the
      user to which you decided, and checking the path to the cron.sh script:

      [root # vi /etc/crontab]
      0,30 * * * *  www-data /usr/bin/php -f /var/www/sigvi/cron/launch_processes.php > /tmp/output-sigvi.txt 2>&1

   Execute it manually and check for results:

   # sudo php -f /var/www/sigvi/cron/launch_processes.php


5. Tunning the PHP

   Some processes will need a lot of time, so if you get error about resource limitations,
   it would be a good idea to increase them.

   Edit your php.ini of the Apache and CLI and set as your own, but those are good values:

     max_execution_time = 90     ; Maximum execution time of each script, in seconds
     memory_limit = 128M      ; Maximum amount of memory a script may consume (128MB)


6. Accessing for first time

   Open a Web browser and go to your location (http://<yourserver>/sigvi)
   Login: username "admin", password "admin"

     Note: if you get an error like this:
     "Warning: dl() [function.dl]: Dynamically loaded extensions aren't enabled"
     Then you have to edit your php config file (usually /etc/php5/apache2/php.ini) and
     set the directive "enable_dl = On".

   Once logged in, you can press the "?" icon to get a little help for
   beggining.

   You can change the configuration manually (better idea) editing the conf/app.conf.php file
   or via Web, using the tools/config.php script.

   For use, please read the user manual at sigvi portal:

     http://sigvi.upcnet.es/doc/manuales/doc.php


7. Help

   Questions and more, at tiochan@gmail.com


Thank you for your interest, I hope you enjoy it.

Sebastián Gómez. 




--------------------------------------------------------------------------------
ABOUT UPGRADES
--------------------------------------------------------------------------------

There is not any upgrade process yet. As soon as the last R2 release is finished
, the upgrade process will be created, taking this release as the starting point
for upgrade to future versions.

I'm sorry, but If you have data from previous versions, you must migrate the 
data manually:
- rename your current database
- install the new version
- try to do a migration process like:
  > truncate sigvi.<table>;
  > insert into sigvi.<table> select * from sigvi_old.<table>
  for each table like users, groups, servers, server_products, vulnerabilities..

A lot of changes on database structure have been done.

