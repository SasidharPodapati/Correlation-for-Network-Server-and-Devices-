#!/usr/bin/perl

use DBI;
use FindBin qw($Bin);
use File::Basename qw(dirname);
use File::Spec::Functions qw(catdir);
use LWP::Simple;
use LWP::UserAgent;
use LWP::Protocol::https;
use RRD::Simple ();
use Data::Dumper;

my $original= $Bin;  
my $directory= dirname($original);
my $finalpath = catdir($directory, 'db.conf');

open (FILE,$finalpath) or die 'Cannot open';

while (my $line = <FILE>) {
        my @fields = (split '"',$line);
	push @data , \@fields;
}
   
foreach my $a_ref ($data['0']) 
{
      $host = $a_ref->[1];
}
foreach my $a_ref ($data['1']) 
{
      $port = $a_ref->[1];
}

foreach my $a_ref ($data['2']) 
{
      $database = $a_ref->[1];
}

foreach my $a_ref ($data['3']) 
{
      $username = $a_ref->[1];
}

foreach my $a_ref ($data['4']) 
{
      $password = $a_ref->[1];
}

$dsn = "DBI:mysql:database=$database;host=$host;port=$port";
$dbh = DBI->connect($dsn,$username,$password);

$sql2 = $dbh->prepare("SELECT * FROM PORT WHERE TYPE ='SERVER' or TYPE='BOTH' ");
$sql2->execute() or die ("can't select\n");

while (@results = $sql2->fetchrow_array()) {
for ($i=0;$i<=6;$i++)
	{
	  @fetch=split(' ',$results[$i]);
	  foreach  $value (@fetch)
	    {
	      $array[$i]=$value;
	    }
        }
$id = "$array[0]";
$IP = "$array[1]";
$HTTPPORT = "$array[3]";

	 system("curl http://$IP:$HTTPPORT/server-status?auto > get.txt");
	open(fh, "<$original/get.txt");

	@row = <fh>;

	foreach $v (@row)
	{
	$cpuload = $1 if($v=~m/CPULoad:\s(\d*.+)/g);
	$uptime = $1 if($v=~m/Uptime:\s(\d*.\d+)/g);
	
	$requests_per_second = $1 if($v=~m/ReqPerSec:\s(\d*.\d+)/g);
	$transferredbytes_per_second = $1 if($v=~m/BytesPerSec:\s(\d*.\d+)/g);
	$noofbytes_per_request = $1 if($v=~m/BytesPerReq:\s(\d*.\d+)/g);
   	}

#Updating rrdtool
$filename = "$original/rrdfiles/server/$array[1]-$array[3].rrd";
	$time = time();
	my $rrd = RRD::Simple->new( file => $filename, cf => [qw(AVERAGE)], default_dstype => "GAUGE", on_missing_ds => "add");
	unless (-e $filename) {
	$rrd->create($filename,"hour",testDS=>"GAUGE");
				}
	$rrd->update("$filename","cpuload"=>"$cpuload","rps"=>"$requests_per_second","tbps"=>"$transferredbytes_per_second","nbps"=>"$noofbytes_per_request");
		
			}
	







