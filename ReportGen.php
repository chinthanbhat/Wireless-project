<?php
$servername = "mydbinstance1.com52r4wudge.us-west-2.rds.amazonaws.com";
$username = "";
$password = "";
$dbname = "BeaconLog";

$conn = new mysqli($servername,$username,$password,$dbname);
$conn2 = new mysqli($servername,$username,$password,$dbname);
$conn3 = new mysqli($servername,$username,$password,$dbname);
$conn4 = new mysqli($servername,$username,$password,$dbname);
$conn5 = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error) {
	die("Connection failed:" . $conn->connect_error);
}

$locateTag = array();
$result = array();
$RSSI = array();
$tagSplit = array();
$Dname = array();
$results = array();
$result2 = array();


$count = 0;
if (isset($_GET['StartDateTime']) && isset($_GET['EndDateTime']) ) {
        //$sdt = "2016-04-29 17:00:00";
$sdt = $_GET['StartDateTime'];
        //$edt = "2016-04-29 18:00:00";
$edt = $_GET['EndDateTime'];
//echo $sdt, $edt;
//http://www.wireless.site88.net/ReportGen.php?StartDateTime=2016-04-29 17:00:00&&EndDateTime=2016-04-29 18:00:00
$result = mysqli_query($conn, "CALL ReportGen('$sdt','$edt')");
}
//while ($row = mysqli_fetch_array($result))
//echo $row[0];
//else 
//echo "Unsuccesful";


$sql2 = " truncate SensorTag_Report";
$conn3->query($sql2);

while ($row = mysqli_fetch_array($result)){ 
$tag = $row[0] . "," . $row[1] . "," . $row[2] . "," . $row[3] . "," . $row[4] . "," . $row[5]; //This holds the complete set of values. 
//$test = explode('/', $row[5]);

//echo 'ST' . $test[3] ;
//echo $row[5];
//echo $tag . "\r\n";
$locateTag[$count] = $tag;
$RSSI[$count] = $row[3]; // Corresponding RSSI
$count++ ;
if($count == 3) {
//echo $RSSI[];
     
//$maxs = max($RSSI);
     $maxs = array_search(max($RSSI),$RSSI); //Gives us the index of the highest RSSI complete record
     //echo $maxs . "/r/n";
     $tagSplit = explode(',',$locateTag[$maxs]);
     //echo $tagSplit[5];
     $Dname = explode('/', $tagSplit[5]); // Contains the chosen sensortag number
     $Dname2 = 'ST' . $Dname[3];
     //mysql_query("INSERT into SensorTag_Report (DeviseName, DeviseRSSI) values ($Dname2, $tagSplit[3])");
     $sql = "INSERT into SensorTag_Report (DeviseName, DeviseRSSI) values ('$Dname2', '$tagSplit[3]')";
     $conn2->query($sql);
     $count = 0;
   }


}

mysqli_query($conn4, "CALL UpdateReport;");
$sql3 = "select * from SensorTag_Report";
$result2 = mysqli_query($conn5, "$sql3");


while($s= mysqli_fetch_assoc($result2))
                           {
                           $results[] = $s;
                           }

                           $json = json_encode(array( 'data' =>$results));
                           echo $json;


?>						