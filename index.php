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
#main {margin: auto;text-align:center;width: 100%;color: #FFFFFF;border:3px solid #000000;padding: 10px;background-color:#660066;font-size:135%;}

</style>
</div>
<div id="navbar">
<ul>
      <li><a href="mgraph.php">Graphs</a></li>
	<li><a href="multiple.php">Select Metrics</a></li>
      <li><a href="#">Add/Delete Devices</a></li>
      
</ul>
<style>
#navbar {line-height:30px;margin:auto;background-color:#660066;height:auto;width:100%;border:1px solid #000000;float:top-right;padding:10px;}
ul {list-style-type: none;margin: 0;padding: 0;overflow: hidden;}
li {float:right;}
a:link, a:visited {display: block;width: 200px;color: #FFFFFF;background-color: #660066;text-align: center;font-size:125%;padding: 4px;text-decoration: none;}
a:hover, a:active {background-color: #000000;}
</style>
</div>
<div><div id="section">
<h2>Enter the Device Credentials</h2>
<form method="post" action=" "> 
IP:  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input type="varchar" name="IP"><br>
SNMP PORT: &nbsp&nbsp<input type="varchar" name="SNMPPORT"><br>
HTTP PORT: &nbsp &nbsp;<input type="varchar" name="HTTPPORT"><br>
COMMUNITY: &nbsp<input type="varchar" name="COMMUNITY"><br><br>
<input type="radio" name="type" value="SERVER" checked>SERVER
<input type="radio" name="type" value="DEVICE" checked>DEVICE
<input type="radio" name="type" value="BOTH" checked>BOTH
<br><br>
<center><input type="submit" name="submit" value="ENTER"></center>
</form>
<style>
#section {margin: auto;text-align:center;width:100%;color: #000000;border:1px solid #000000;padding:10px;background-color:#E8E8E8;}   
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

$sql1="CREATE TABLE IF NOT EXISTS PORT (
id int (11) NOT NULL AUTO_INCREMENT,
IP tinytext NOT NULL,
SNMPPORT int (11) NOT NULL,
HTTPPORT int (11) NOT NULL,
COMMUNITY tinytext NOT NULL,
TYPE text NOT NULL,
INTERFACES varchar(48000) NOT NULL,
PRIMARY KEY ( id )
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
$result = mysqli_query($con, $sql1);
if ($result) {
    #echo "Enter the values";
} else {
    echo "Error creating table: " . $con->error;
}?>

<p>
<?php

if(!empty($_POST['IP'])){
$IP=$_POST['IP'];
$SNMPPORT=$_POST['SNMPPORT'];
$HTTPPORT=$_POST['HTTPPORT'];
$COMMUNITY=$_POST['COMMUNITY'];
$TYPE=$_POST['type'];
$sql2="INSERT INTO PORT (IP,SNMPPORT,HTTPPORT,COMMUNITY,TYPE,INTERFACES)
VALUES ('$IP','$SNMPPORT','$HTTPPORT','$COMMUNITY','$TYPE','NULL')";
$result2 = mysqli_query($con,$sql2);
if($result2){
  echo("Input data stored");
} else{
    echo("input data fail");
}
}
?> </p>

<?php

$con= new mysqli($host,$username,$password,$database);
if ($con->connect_error)
  {
  echo "Failed to connect to database: ". $con->connect_error ;
  }

mysqli_select_db($con,$database) or die ("Cannot select DB");
$sql3 = "SELECT * FROM PORT";
$result3 = mysqli_query($con,$sql3);
print "<center><table cellpadding=5></center>"; 
print  "<tr>";
print  "<th>ID</th>";
print  "<th>IP</th> ";
print  "<th>SNMPPORT</th> ";
print  "<th>HTTPPORT</th> ";
print  "<th>COMMUNITY</th>";
print  "<th>Server/Device/Both</th>";
print  "<th>INTERFACES</th>";
print  "<th>DELETE</th> ";
print  "</tr>";

$PHP_SELF = " ";

 $sql311d = "SELECT * FROM PORT";
 $result311d = mysqli_query($con,$sql311d);
 while ($fetch = mysqli_fetch_assoc($result311d))
{
 $id = $fetch['id'];
 $oid = "1.3.6.1.2.1.2.2.1.1";
 $walk = snmpwalk("$fetch[IP]:$fetch[SNMPPORT]","$fetch[COMMUNITY]","$oid");
 
 $output = array();
 foreach ($walk as $value){
 	$split = explode(' ',$value);
	$output[] = "$split[1]";
 	$list =  implode(",",$output);
 			  }
if($walk){
echo "<b>ID:$id</b> -- $list\n<br>";
}else
{
echo "<b>ID:$id</b> -- no interfaces \n <br>";
}
if(isset($_POST['id'])){
$ID=$_POST['id'];

$INTERFACES=$_POST['interfaces'];

$sqlu = "UPDATE PORT SET INTERFACES = '$INTERFACES' WHERE id = $ID";
if ($con->query($sqlu) === TRUE) {
    #echo "Interfaces added";
} else {
    #echo "Error updating";
}
}
 print "<tr>"; 
 print "<td>".$fetch['id']."</td>";
 print "<td>".$fetch['IP']."</td>";
 print "<td>".$fetch['SNMPPORT']."</td>";
 print "<td>".$fetch['HTTPPORT']."</td>";
 print "<td>".$fetch['COMMUNITY']."</td>";
 print "<td>".$fetch['TYPE']."</td>";
 print "<td>".$fetch['INTERFACES']."</td>";
 print "<td><a href='$PHP_SELF?id=$fetch[id]'>Delete</a></td>";
 print "</tr>";

#echo "ID:$id -- $list\n";
}

print"</table><br><br>";

if(isset($_GET['id']))
{
$uid=$_GET['id'];

$delete = "DELETE FROM PORT where id='$uid'";
if(mysqli_query($con,$delete)){
?>
<p><?php echo "Data Deleted Successfully";
} 
}
?>
<h2> Enter interfaces to be probed separated by comma. For ex: 1,2,3,4 </h2>
<form method="post" action=" "> 
ID: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<input type="int" name="id"><br>
INTERFACES:&nbsp&nbsp&nbsp<input type="varchar" name="interfaces"><br>
<br>
<center><input type="submit" name="submit" value="GO"></center>
</form>


      
 


 








</div>
</body>
</html> 






