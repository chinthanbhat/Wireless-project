<?php
    
    define('DB_USER', ""); // db user
    define('DB_PASSWORD', ""); // db password (mention your db password here)
    define('DB_DATABASE', "BeaconLog"); // database name
    define('DB_SERVER', "mydbinstance1.com52r4wudge.us-west-2.rds.amazonaws.com"); // db server
    
    // Connecting to mysql database
    $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());
    $results = array();
    if (isset($_GET['StartDateTime']) && isset($_GET['EndDateTime']) ) {
        $sdt = $_GET['StartDateTime'];
        $edt = $_GET['EndDateTime'];
echo $sdt,$edt;
        $sql = mysql_query("SELECT * FROM BeaconLog.ArtificialData  Where BeaconLog.ArtificialData.TStamp >= '$sdt' && BeaconLog.ArtificialData.TStamp <= '$edt'");
                          

                           while($s= mysql_fetch_assoc($sql))
                           {
                           $results[] = $s;
                           }

                           $json = json_encode(array( 'data' =>$results));
                           echo $json;

               
}

?>	