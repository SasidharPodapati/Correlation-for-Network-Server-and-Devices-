#!/usr/bin/perl

use DBI;
use FindBin qw($Bin);
use File::Basename qw(dirname);
use File::Spec::Functions qw(catdir);
use Net::SNMP;
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

$sql2 = $dbh->prepare("SELECT * FROM PORT WHERE TYPE ='DEVICE' or TYPE='BOTH' ");
$sql2->execute() or die ("can't select\n");

my $InOctets = ".1.3.6.1.2.1.2.2.1.10";
my $OutOctets = ".1.3.6.1.2.1.2.2.1.16";
my %devs;


while (my $result = $sql2->fetchrow_hashref()) {
	my $id = "Dev".$result->{'id'};
	my $ip = $result->{'IP'};
	my $port = $result->{'SNMPPORT'};
	my $community = $result->{'COMMUNITY'};
	my @interfaces = split(',', $result->{'INTERFACES'});
	
	$devs{$id}{"ip"} = $ip;
	$devs{$id}{"port"} = $port;
	$devs{$id}{"community"} = $community;

	push @all,"$InOctets.$_","$OutOctets.$_" for(@interfaces);

	my $session = Net::SNMP->session(-hostname	=> $ip, 
					 -port		=> $port, 
					 -community	=> $community, 
					 -timeout	=> 1,
					 -retries	=> 0,
					 -nonblocking	=> 1);
	if (!defined($session)) {
    printf("ERROR SESSION: %s.\n",  $error);
			}
	
	while (@all){
		@oids = splice @all, 0, 40 ;
		$dev_sys = $session->get_request(-varbindlist=>\@oids,	-callback=>[\&validgo,$id]);
			}
}

		snmp_dispatcher();
		
	sub validgo{
	my ($session,$id) = @_;
	
	$list = $session->var_bind_list();
	@names = $session->var_bind_names();
	for $name(@names){
		$name=~s/^\s+|\s+$//g;
		if($name=~m/^$InOctets\./){
			$devs{$id}{"Interfaces"}{$'}[0] = $list->{$name};
		}elsif($name=~m/^$OutOctets\./){
			$devs{$id}{"Interfaces"}{$'}[1] = $list->{$name};
		}
	}
}

		
		for $dev(keys(%devs)){

	my $ip = $devs{$dev}{"ip"};
	my $port = $devs{$dev}{"port"};
	my $comm = $devs{$dev}{"community"};

	my $filename = "$original/rrdfiles/devices/$ip-$port-$comm.rrd";
        
	my $rrd = RRD::Simple->new(file => $filename, cf => [qw(AVERAGE)], default_dstype => "GAUGE", on_missing_ds => "add");
	
	if(defined $devs{$dev}{'Interfaces'}){
	
	unless(-e $filename){
	$rrd->create($filename, "year", map{("Interface$_-in"=>"COUNTER", "Interface$_-out"=>"COUNTER")} keys($devs{$dev}{'Interfaces'}));
			}
	
	$rrd->update($filename, map{("Interface$_-in"=>"$devs{$dev}{'Interfaces'}{$_}[0]", "Interface$_-out"=>"$devs{$dev}{'Interfaces'}{$_}[1]")} keys($devs{$dev}{'Interfaces'}));
	
	print "done"."\n";
		
		}
}


	

		


