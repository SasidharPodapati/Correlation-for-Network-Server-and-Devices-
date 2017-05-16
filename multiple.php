<head>
<title>Probe Based Operations</title>
<link href="style.css" rel="stylesheet">
</head>

<body>
<body bgcolor="	#FFF5EE">
<div><div id="main">
<h1>Probe Based Operations</h1>
<style>
#main {margin: auto;text-align:center;width: 80%;color: #FFFFFF;border:3px solid #000000;padding: 10px;background-color:#660066;font-size:135%;}
</style>
</div>
<div id="navbar">
<ul>
	<li><a href="mgraph.php">Graph</a></li>
	
	<li><a href="#">Select Metrics</a></li> 
      
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
<h2>  Select the device/server to be monitored </h2>
<style>
#section {margin: auto;text-align:center;width: 80.25%;color: #000000;border:1px solid #000000;padding:10px;background-color:#E8E8E8;}   
p {
    text-align:center;color:#FFFFFF;border:1px solid #000000;padding:1px;background-color:#660066;border-top:50px;bottom:0;border-left:50px;
}
table, th, td {
    border: 1px dotted black; 
}
</style>

<form method="GET" action=mgraph.php> 
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
mysqli_select_db($con,$database) or die ("Cannot select DB");

$sql3 = "SELECT * FROM PORT WHERE TYPE = 'DEVICE'";
$result3 = mysqli_query($con,$sql3);
print "<center><table cellpadding=5></center>"; 
print  "<tr>";
print  "<th>Select</th>";
print  "<th>ID</th>";
print  "<th>IP</th> ";
print  "<th>SNMPPORT</th> ";
print  "<th>HTTPPORT</th> ";
print  "<th>COMMUNITY</th>";
print  "<th>Server/Device/Both</th>";
print  "<th>INTERFACES LIST</th>";
print  "<th>INTERFACES PROBE</th>";
print  "<th>Metrics</th>";
print  "</tr>";


$sql311d = "SELECT * FROM PORT WHERE TYPE = 'DEVICE'";
 $result311d = mysqli_query($con,$sql311d);
 while ($fetch = mysqli_fetch_assoc($result311d))
{

 print "<tr>"; 
 #print "<form action=mgraph.php method='GET'>";
 print "<td> <input id='$fetch[id]' type='checkbox' name='id[]' value='$fetch[id]'> </td>"; 
 print "<td>".$fetch['id']."</td>";
 print "<td>".$fetch['IP']."</td>";
 print "<td>".$fetch['SNMPPORT']."</td>";
 print "<td>".$fetch['HTTPPORT']."</td>";
 print "<td>".$fetch['COMMUNITY']."</td>";
 print "<td>".$fetch['TYPE']."</td>";
 print "<td>".$fetch['INTERFACES']."</td>";
 print "<td><input type=\"$fetch[id]int\" name=\"$fetch[id]inn\"/></td>";
 print "<td><input type=\"checkbox\" name=\"$fetch[id]metricd1\" value=\"Inbitrate\" />InBitrate<br>
        <input type=\"checkbox\" name=\"$fetch[id]metricd2\" value=\"Outbitrate\" />OutBitrate<br>
        <input type=\"checkbox\" name=\"$fetch[id]metricd3\" value=\"aggregatedbitrate\" />AggregatedBitrate <br></td>";
 print "</tr>";

#print "<input type='hidden' name='did' value=$fetch[id]> ";   
print "<input type='hidden' name='IP' value=$fetch[IP]> ";    
print "<input type='hidden' name='SNMPPORT' value=$fetch[SNMPPORT]> ";  
print "<input type='hidden' name='HTTPPORT' value=$fetch[HTTPPORT]> ";
print "<input type='hidden' name='COMMUNITY' value=$fetch[COMMUNITY]> ";  
print "<input type='hidden' name='TYPE' value=$fetch[TYPE]> "; 
print "<input type='hidden' name='INTERFACES' value=$fetch[INTERFACES]> ";  

}

print"</table><br>";
?>

  
    
<center><input type="submit" name="submit" value="ADD"></center><br>
</form>

<?php
$con= new mysqli($host,$username,$password,$database);
if ($con->connect_error)
  {
  echo "Failed to connect to database: ". $con->connect_error ;
  }

mysqli_select_db($con,$database) or die ("Cannot select DB");

$sql3a = "SELECT * FROM PORT WHERE TYPE = 'SERVER'";
$result3a = mysqli_query($con,$sql3a);
print "<center><table cellpadding=5></center>"; 
print  "<tr>";
print  "<th>Select</th>";
print  "<th>ID</th>";
print  "<th>IP</th> ";
print  "<th>SNMPPORT</th> ";
print  "<th>HTTPPORT</th> ";
print  "<th>COMMUNITY</th>";
print  "<th>Server/Device/Both</th>";
print  "</tr>";

$sql311da = "SELECT * FROM PORT WHERE TYPE = 'SERVER'";
 $result311da = mysqli_query($con,$sql311da);
 while ($fetch = mysqli_fetch_assoc($result311da))
{

 print "<tr>";
 print "<td> <input type='checkbox' name='sid[]' value='$fetch[id]'> </td>";  
 print "<td>".$fetch['id']."</td>";
 print "<td>".$fetch['IP']."</td>";
 print "<td>".$fetch['SNMPPORT']."</td>";
 print "<td>".$fetch['HTTPPORT']."</td>";
 print "<td>".$fetch['COMMUNITY']."</td>";
 print "<td>".$fetch['TYPE']."</td>";
 print "</tr>";

#print "<input type='hidden' name='sid' value=$fetch[id]> ";   
print "<input type='hidden' name='IP' value=$fetch[IP]> ";    
print "<input type='hidden' name='SNMPPORT' value=$fetch[SNMPPORT]> ";  
print "<input type='hidden' name='HTTPPORT' value=$fetch[HTTPPORT]> ";
print "<input type='hidden' name='COMMUNITY' value=$fetch[COMMUNITY]> ";  
print "<input type='hidden' name='TYPE' value=$fetch[TYPE]> "; 
print "<input type='hidden' name='INTERFACES' value=$fetch[INTERFACES]> ";  
}
print"</table><br>";
?>


  <input type="checkbox" name="metric1" value="cpuload" /> Cpu Usage
  <input type="checkbox" name="metric2" value="rps" /> Requests/second
  <input type="checkbox" name="metric3" value="tbps" /> Transferred Bytes/second
  <input type="checkbox" name="metric4" value="nbps" /> Number of Bytes/request

<center><input type="submit" name="submit" value="ADD"></center><br>
</form>

<center><input type="submit" name="submit" value="submit"></center><br>
</form>


</div>
</body>
</html> 


