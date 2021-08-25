<?php
set_time_limit(800);
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
//ค่า Default**********************************************************
$data = "default"; 
// echo $data;

?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="FsFm381uAxDoym64mxN7C6SB_nNqrxHoiunMnM7Eh3A" />
    <!-- CSRF Token -->
	<link rel="shortcut icon" href="images/001.png" />
    <title>AEFI อัพเดต</title>
    
	<link href="https://fonts.googleapis.com/css2?family=Mitr:wght@300&family=Prompt:wght@100;200;300&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@600&family=Sriracha&display=swap" rel="stylesheet">

    <!-- Styles -->
	<link href="https://fonts.google.com/share?selection.family=Mitr:wght@200;300%7CPrompt:wght@100" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  	<link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
</head>

<body style="background-color:#ffffff;
			font-family: 'Mitr', sans-serif;
            font-family: 'Prompt', sans-serif;" >

    <div class="container">
        <form method="post"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="input-group my-3">
            <input type="text" class="form-control d-none" id="datasend" name="datasend" value="OK">
            <div class="input-group">
                <button class="btn btn-primary btn-sm" type="submit">
                    UpdateData
                </button>
            </div>
            </div>
        </form> 
        

<?php
date_default_timezone_set("Asia/Bangkok");
$datetime = date('Y-m-d H:i:s'); 

if (isset($_POST['datasend'])) {
    $data = $_POST['datasend'];
    echo $data;


   // CREATE TABLE eoc_vaccine_brand AS
   // (SELECT vaccine_manufacturer,vaccine_plan_no,ref_hospital_name,count(*) as total FROM visit_immunization group by vaccine_manufacturer,ref_hospital_name,vaccine_plan_no order by vaccine_manufacturer_id)
    
//    SELECT vaccine_manufacturer,
//    SUM(CASE when vaccine_plan_no = 1 then total else 0 end) as Dose1,
//    SUM(CASE when vaccine_plan_no = 2 then total else 0 end) as Dose2,
//    SUM(CASE when vaccine_plan_no = 3 then total else 0 end) as Dose3,
//    SUM(CASE when vaccine_plan_no = 4 then total else 0 end) as Dose4,
//     SUM(total) as totalall
//    FROM eoc_vaccine_brand group by vaccine_manufacturer with rollup
}