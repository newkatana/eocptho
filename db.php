<?php
$servername = "hdc.ptho.moph.go.th";
$username = "root";
$password = "adminhdc";
$dbname = "covid19_report";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);
mysqli_query($con,"set character set utf8");
// Check connection
if (!$con){
    echo "Not connect to server";
}
if (!mysqli_select_db($con,'covid19_report')){
	echo "Not Connect To DataBase";
}

include "function.php";

?>