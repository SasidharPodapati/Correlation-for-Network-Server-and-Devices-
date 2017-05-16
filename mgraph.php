<html>
<head>
<title>Correlation of Service and Network Communications</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<body bgcolor="	#FFF5EE">
<div><div id="main">
<h1>Correlation of Service and Network Communications</h1>
<style>
#main {margin: auto;text-align:center;width: 80%;color: #FFFFFF;border:3px solid #000000;padding: 10px;background-color:#660066;font-size:135%;}
</style>
</div>
<div id="navbar">
<ul>
	<li><a href="#">Graph</a></li>
      
      <li><a href="multiple.php">Select Metrics</a></li>
	
      <li><a href="index.php">Add/Delete Devices</a></li>
      
</ul>
<style>
#navbar {line-height:30px;margin:auto;background-color:#660066;height:auto;width:80.15%;border:1px solid #000000;float:top-right;padding:10px;}
ul {list-style-type: none;margin: 0;padding: 0;overflow: hidden;}
li {float:right;}
a:link, a:visited {display: block;width: 200px;color: #FFFFFF;background-color: #660066;text-align: center;font-size:125%;padding: 4px;text-decoration: none;}
a:hover, a:active {background-color: #000000;}
</style>
</div>
<div><div id="section">
<style>
#section {margin: auto;text-align:center;width: 80.15%;color: #000000;border:1px solid #000000;padding:10px;background-color:#E8E8E8;}   
p {
    text-align:center;color:#FFFFFF;border:1px solid #000000;padding:1px;background-color:#660066;border-top:50px;bottom:0;border-left:50px;
}
table, th, td {
    border: 1px dotted black; 
}
</style>

<?php
$this_dir = dirname(__FILE__);
$path = realpath($this_dir . '/..');
$target_path = $path . '/db.conf';
$final = file($target_path);

for($i=0;$i<=4;$i++)
	{
	   $data=explode('"',$final[$i]);
	   $out[$i]="$data[1]";
	}

$host = $out[0];
$port = $out[1];
$database = $out[2];
$username = $out[3];
$password = $out[4];

$con= new mysqli($host,$username,$password);
if ($con->connect_error)
  {
  echo "Failed to connect to MySQL: ". $con->connect_error ;
  }

$sql = "CREATE DATABASE if not exists $database";
if ($con->query($sql) === TRUE) {
    #echo "Database created successfully";
} else {
    echo "Error creating database: " . $con->error;
}
$con= new mysqli($host,$username,$password,$database);
if ($con->connect_error)
  {
  echo "Failed to connect to database: ". $con->connect_error ;
  }
$colours = array("6BD432","0442B3","4F41DE","1D474E","D4283D","2A9FEC","2F162C","A7BE89","C9711C","FF0283","0AEAAC","6DC84E","4E60CF","A992BA","EB9FE2","3EC187","EF4A79","9C7FD4","F8E8A9","285C83","EB2BCB","3AA852","1EF8ED","DD5B5F","588A50","E4C008","B336B9","8C8856","534AFA","A53308","3ED0ED","990CFC","689E0F","562901","4B77E7","025D23","ABDB8D","7E60D7","02D2CE","419B88","29A87D","C299D2","751E6E","56129D","0DEA97","2C1D48","B0A4A8","62D703","65A783","48033A","B56C3A","5EBF36","8A8518","98E3F6","64E681","13770A","259E5C","4D6C38","5C03F0","9547CC","9D0150","B7656C","1AA86D","1BA2EA","28F7FC","49A4A0","568CBE","8D836F","08BBA9","5D1541","28BCD6","C2C4E8","276BAD","AA556F","FBD101","32AEF7","5C9108","A3F1F9","EA44FA","4F5106","249C39","485DA6","55A469","D53293","CE22F3","8282FB","B3301E","6630B9","A9FEB9","1774A7","72AF59","B0CF1D","D84090","A39915","32DB77","2EACEF","690281","069562","515EB7","4EA191","8C028E","1E8111","327C7E","EDF4CA","C09612","79F8B8","7D60F8","12B9E3","8D082C","2ECC4D","FC7E53","6C0DC0","5E2181","40E491","1BFD84","B71356","6B278F","8EDAF6","C47B90","CACB84","F4B070","7EC964","8E3693","C57301","4CB084","488090","00FDA5","13459D","8630A3","1E0DE9","131A3B","A4B916","F39382","119423","842911","2344D8","F8CB2E","121B6A","D7C7CE","B53DE4","F18366","C6F921","7349EA","3C2F4E","EF41D3","6C4F0B","5C1463","6D7A66","4A37A8","597AA5","D11212","D6FFB5","323AC9","11358E","DE7582","A54C85","F5CE47","47A726","048491","37FAC8","C7E046","53B210","A684DA","BEF338","46040D","CD4AD8","13CD6E","D04641","0F0033","9799CA","687B35","45902F","E0F264","473476","80E19A","B033B7","9FC2FE","2EE114","55C9A3","F23E4D","80DC39","3D8FF8","E17C38","19ED29","12B400","290054","991281","B62235","B5E931","243E94","EBDFB3","35C575","62C840","E05D99","ECE2A7","69348F","8C441C","A7E603","7F3CDD","6C94E4","B5DFA5","F21463","01BE8B","2FB6C8","324C63","128E22","41565C","95D445","074BD1","4139EA","CFD5DF","820D86","92B760","C78135","276515","0D4D32","CB4D9C","32EF95","06C870","DA8409","907EDA","0A547E","1B1FAA","4B1138","213A63","4F3BE1","5EBB23","A3EB39","6847A8","0C937F","6CFA7D","BDB78E","A329E6","34E8C8","0D590D","979810","5DE147","0FA298","8CD759","0575F7","28FC10","D6DB82","281CAB","5373AD","CA2402","B3BAFC","BC298A","BA2D7D","8D000B","DD6016","3CAE7A","A26DBE","879B41","9DEADE","5BBCBC","2F9DD0","783E5F","CE669B","7285C6","321FED","B1C4E9","561847","715E7F","9F225F","891980","631380","DD6E6B","6ECBC4","B63D89","C02EAA","E1E046","01470A","268F25","3DB7A3","07435E","D30B34","2467C6","2EDBE0","02DCA8","0AF4D5","3B837C","8A0E1D","53B2EA","2FC0B6","9B190F","E3B762","3FC4DE","121D50","88F48B","B16DA7","C8A701","A3068E","5A0686","70E656","2089D2","0ABB1B","CCFD38","B82CEB","26B0D0","6F1E8E","189D3B","8078DA","192451","F77A74","BE4CDC","BE55C9","05A7D8","2E1437","62EED6","385752","31196D","372DE0","50F652","DC4CA1","3DA840","B81C28","A5FD2E","D7FDE5","FC148B","5C904D","0F62C8","B7DB4F","A279F5","FE102A","C8659B","39BAC8","27F024","FD6766","C65E68","930F99","BD367F","E97EAA","2A791E","0D45CB","D5FE58","805B6C","B56341","D7B51C","31A866","44B320","BA1168","E2D552","63918A","DBB742","E869B9","A74B8B","36D1B3","326D3E","81A39E","676D12","6B9B71","6B84C4","706EEA","D6B7A4","60CCDD","E49800","96B1B8","629C17","6ED257","7C7395","08A90A","A915BC","E1F7E0","E4EB74","3E0B1A","022BC2");

?>


<?php

## -- Device Graphs -- ##

if(!empty($_GET['id'])){
$did=$_GET['id'];
}
foreach($did as $id)
{
$time   = time();

$inarr = array();
$outarr = array(); 

								
$sql1 = "SELECT * FROM PORT WHERE id='$id'";
$result1=mysqli_query($con, $sql1);

	while($rows =mysqli_fetch_array($result1))
		{
			
			$ipd = $rows['IP'];	
			$port1d = $rows['SNMPPORT'];
			$port2d = $rows['HTTPPORT'];
			$communityd = $rows['COMMUNITY'];
			$infaces = $rows['INTERFACES'];

		}
$device1 = htmlspecialchars($_GET[$id."metricd1"]);
$device2 = htmlspecialchars($_GET[$id."metricd2"]);
$device3 = htmlspecialchars($_GET[$id."metricd3"]);


$named = "$ipd"."-"."$port1d"."-"."$communityd";
$filenamedevice =  "$this_dir/rrdfiles/devices/$named.rrd";

echo "<h2>Devices Graphs</h2>";	


if(!empty($_GET[$id.'inn'])){
$inn=$_GET[$id.'inn'];
}

echo"---------------------------<br>";echo "METRICs FOR DEVICE $named: $device1, $device2, $device3, interface: $inn<br>";echo"---------------------------<br>";
$infacesep = explode(",",$inn);

if($device1 === "Inbitrate" && $device2 === "Outbitrate" && $device3 === "aggregatedbitrate") {
echo "<h3>$ipd-$port1d-$communityd</h3>";
$inout = array( "--start", "-1h", "--vertical-label=Bytes per second",
				"--dynamic-labels",
			 	"--title=Combined graph",
	  		 	"--color=BACK#CCCCCC",      
		    	 	"--color=CANVAS#CCFFFF",    
		    	 	"--color=SHADEB#9999CC");
		    	 	$i=0;
		    	 	
		foreach ($infacesep as $inter)
		{
                 array_push($inout,"DEF:inoctets$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-in:AVERAGE", 
                                   "LINE:inoctets$inter#$colours[$i]:In bit-$inter",
                                   "GPRINT:inoctets$inter:AVERAGE:Current Inbitrate \: %6.2lf %Sbps",
                                   "DEF:outoctets$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-out:AVERAGE",
                                   "LINE:outoctets$inter#".$colours[++$i].":Out bit-$inter",
                                   "GPRINT:outoctets$inter:AVERAGE:Current Outbitrate \: %6.2lf %Sbps");
		 array_push($inout,"DEF:in$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-in:AVERAGE",
		                   "DEF:out$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-out:AVERAGE");
		                   $i++;
		}
		
		
		for($i=0;$i<count($infacesep);$i++)
		{
		 if($i==0)
		 {
		  $str_in = "in$infacesep[$i]";$str_out = "out$infacesep[$i]";
		 }
		 else
		 {
		  $str_in = $str_in.",in$infacesep[$i],+";$str_out = $str_out.",out$infacesep[$i],+";
		 }
		}
	array_push($inout,"CDEF:AggIn=$str_in","LINE2:AggIn#00FF00:Aggregate In bit",
		   "CDEF:AggOut=$str_out","LINE2:AggOut#0000ff:Aggregate Out bit",
		   "COMMENT:\\n","GPRINT:AggIn:AVERAGE: Aggregate In bitrate \: %6.2lf %Sbps",
		   "COMMENT:  ", 
		   "GPRINT:AggOut:AVERAGE: Aggregate Out bitrate \: %6.2lf %Sbps",
		   "COMMENT:\\n");
		   		
		   		
				$ret_inout = rrd_graph("$this_dir/rrdfiles/devices/$named.png", $inout);
				if( !($ret_inout) )
  				{
    				$err = rrd_error();
    				echo "rrd_graph() ERROR: $err\n";
  				}
				echo "<img src=image.php?image=$this_dir/rrdfiles/devices/$named.png>";
				}
				

		else {
		if($device1 === "Inbitrate" ) {
		echo "<h3>$ipd-$port1d</h3>";
		$inarr = array( "--start", "-1h", "--vertical-label=Bytes per second",
		         	"--dynamic-labels",
			 	"--title=In Octect ",
	  		 	"--color=BACK#CCCCCC",      
		    	 	"--color=CANVAS#CCFFFF",    
		    	 	"--color=SHADEB#9999CC",
		              );
		  $i=0;
		 foreach ($infacesep as $inter)
		{
                 array_push($inarr,"DEF:inoctets$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-in:AVERAGE", 
                                   "LINE:inoctets$inter#$colours[$i]:In bit-$inter",
                                   "GPRINT:inoctets$inter:AVERAGE:Current Inbitrate \: %6.2lf %Sbps");
         	 $i++;
		}
		         		
				$ret_in = rrd_graph("$this_dir/rrdfiles/devices/Interface$named-in.png", $inarr);
				if( !($ret_in) )
  				{
    				$err = rrd_error();
    				echo "rrd_graph() ERROR: $err\n";
  				}
				echo "<img src=image.php?image=$this_dir/rrdfiles/devices/Interface$named-in.png><br>";
				}
			
		 if($device2 === "Outbitrate" ) {	
		echo "<h3>$ipd-$port1d</h3>";
		$Outarr = array( "--start", "-1h", "--vertical-label=Bytes per second",
		         	"--dynamic-labels",
			 	"--title=Out Octect ",
	  		 	"--color=BACK#CCCCCC",      
		    	 	"--color=CANVAS#CCFFFF",    
		    	 	"--color=SHADEB#9999CC",
		              );
		  $i=0;
		 foreach ($infacesep as $inter)
		{
                 array_push($Outarr,"DEF:Outoctets$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-out:AVERAGE", 
                                   "LINE:Outoctets$inter#$colours[$i]:Out bit-$inter",
                                   "GPRINT:Outoctets$inter:AVERAGE:Current Outbitrate \: %6.2lf %Sbps");
         	 $i++;
		}
		         		
				$ret_in = rrd_graph("$this_dir/rrdfiles/devices/Interface$named-out.png", $Outarr);
				if( !($ret_in) )
  				{
    				$err = rrd_error();
    				echo "rrd_graph() ERROR: $err\n";
  				}
				echo "<img src=image.php?image=$this_dir/rrdfiles/devices/Interface$named-out.png><br>";

				}

		 if($device3 === "aggregatedbitrate" ) {
echo "<h3>$ipd-$port1d</h3>";

$agg = array( "--start", "-1h", "--vertical-label=bits/second",
		 "--dynamic-labels",
			 "--title=Aggregated BitRate",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		);

		foreach ($infacesep as $inter)
		{

		array_push($agg,"DEF:in$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-in:AVERAGE",
		 "DEF:out$inter=$this_dir/rrdfiles/devices/$named.rrd:Interface$inter-out:AVERAGE");
		};
		for($i=0;$i<count($infacesep);$i++)
		{
		 if($i==0)
		 {
		  $str_in = "in$infacesep[$i]";$str_out = "out$infacesep[$i]";
		 }
		 else
		 {
		  $str_in = $str_in.",in$infacesep[$i],+";$str_out = $str_out.",out$infacesep[$i],+";
		 }
		}
	array_push($agg,"CDEF:AggIn=$str_in","LINE2:AggIn#00FF00:Aggregate In bit",
		   "CDEF:AggOut=$str_out","LINE2:AggOut#0000ff:Aggregate Out bit",
		   "COMMENT:\\n","GPRINT:AggIn:AVERAGE:Average Aggregate In bitrate \: %6.2lf %Sbps",
		   "COMMENT:  ", 
		   "GPRINT:AggOut:AVERAGE:Average Aggregate Out bitrate \: %6.2lf %Sbps",
		   "COMMENT:\\n");
			$ret_agg = rrd_graph("$this_dir/rrdfiles/devices/Aggregate$named.png", $agg);
			if( !$ret_agg )
  			{
    			$err = rrd_error();
    			echo "rrd_graph() ERROR: $err\n";
  			}
			echo "<img src=image.php?image=$this_dir/rrdfiles/devices/Aggregate$named.png><br>";

}
}
}
?>
	
<?php

## -- Server Graphs -- ## 
if(!empty($_GET['sid'])){
$sid=$_GET['sid'];
}

$server1 = htmlspecialchars($_GET['metric1']);
$server2 = htmlspecialchars($_GET['metric2']);
$server3 = htmlspecialchars($_GET['metric3']);
$server4 = htmlspecialchars($_GET['metric4']);

echo "<h2>Server Graphs</h2>";
$ser_metrics = array($server1,$server2,$server3,$server4);
foreach($ser_metrics as $smet)
{
 if($smet)
 {
 if($smet === 'cpuload'){$title = 'CPU load'; $unit = '%%';}
 elseif($smet === 'rps'){$title = 'Request Per Second'; $unit = 'rps';}
 elseif($smet === 'tbps'){$title = 'Transfered Bytes Per Second'; $unit = 'bps';}
 elseif($smet === 'nbps'){$title = 'Number of Bytes Per Request'; $unit = 'bps';}
 echo "<h3>$title<h3>";
 $graph = array("--start", "-1h", "--vertical-label=$title",	
			 "--dynamic-labels",
			 "--title=$title",
	  		 "--color=BACK#CCCCCC",      
		    	 "--color=CANVAS#CCFFFF",    
		    	 "--color=SHADEB#9999CC"); 
 $i=0;
 foreach($sid as $serid)
 {
 $time   = time();   

 $sql2 = "SELECT * FROM PORT WHERE id='$serid'";
 $result2=mysqli_query($con, $sql2);

  while($row =mysqli_fetch_array($result2))
  {
   $id = $row['id'];
   $ip = $row['IP'];	
   $port1 = $row['SNMPPORT'];
   $port2 = $row['HTTPPORT'];
   $community = $row['COMMUNITY'];
 }
 $name = "$ip"."-"."$port2";
 $filenameserver =  "$this_dir/rrdfiles/server/$name.rrd";
 
  array_push($graph,"DEF:met$id$smet=$filenameserver:$smet:AVERAGE",
	            "LINE:met$id$smet#$colours[$i]:$name HTTP-$smet", 
	            "COMMENT:\\n",
	            "GPRINT:met$id$smet:LAST:Last $smet \: %6.2lf %S$unit",
	            "COMMENT:\\n");
			$i++;
 }
 
 $ret_cpu = rrd_graph("$this_dir/rrdfiles/server/$smet$name.png", $graph);
			if( !$ret_cpu )
  				{
    				$err = rrd_error();
    				echo "rrd_graph() ERROR: $err\n";
  				}
			echo "<img src=image.php?image=$this_dir/rrdfiles/server/$smet$name.png>";
} 
}
?>





</div>
</body>
</html> 

