***Assignment 2***

The main aim of this assignment is to evaluate the performance of server and to build a tool that allows us to correlate performance metrics from both the network and the application.
Results are displayed on web dashboard.

***Software requirements and Basic Installations***
			
Operating System: Ubuntu 14.04 LTS.
Mysql-server, Php5, Apache server.
snmp, snmpd.

***Install packages from terminal*** 
(sudo apt-get install ____)
apache2
mysql-server
php5
libdbi-perl
libsnmp-perl
libpango1.0-dev
libxml2-dev
rrdtool
libwww-perl libcrypt-ssleay-perl

(sudo perl -MCPAN -e _____) 
'install NET::SNMP'
'install lwp::protocol::https'
'install NET::SNMP::Interfaces'
'install RRD::Simple'

***Steps to run the Assignment 2***

*Go to the terminal and go to the working directory i.e. /var/www/html.
*Open a web browser and type the following URL: http://localhost/et2536-sapo15/assignment2 and add the required devices and server.
*Run the backend script using command "perl backend.pl".
*Select the server and interface ids and click on add to monitor metrics and graphs.
*Always wait for the values to be updated.

***Note***
Make sure to enter right credentials.
The webserver you are using should have the read and write permissions to the directory et2536-sapo15 and to the assignmnets directories.
snmp and http permissions should be enabled on the device/server that you are monitoring.
