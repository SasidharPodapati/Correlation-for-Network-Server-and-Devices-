#!/usr/bin/perl
use FindBin qw($Bin);

my $original= $Bin;

while(true)
{

system("perl $original/servers.pl");
system("perl $original/devices.pl");

sleep (60);

}
