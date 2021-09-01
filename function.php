<?php

date_default_timezone_set("Asia/Bangkok"); 

function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    //whether ip is from the remote address  
        else{  
                $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
    }  
    $ip = getIPAddress();  
    $page_url = $_SERVER['QUERY_STRING'];
    $visit_date = date("Y-m-d");
    $visit_datetime = date("H:i:s");

    $sql_ip = "INSERT INTO eoc_get_ip (ip_address, page_url, visit_date, visit_datetime)
    VALUES ('$ip','$page_url', '$visit_date','$visit_datetime')";

    if (mysqli_query($con, $sql_ip)) {
    // echo "New record created successfully";
    } else {
    // echo "Error: " . $sql_ip . "<br>" . mysqli_error($con);
    }

function DateThai($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        // return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
        return "$strDay $strMonthThai $strYear เวลา  $strHour.$strMinute น.";
    }
    function DateThai2($strDate)
    {
        $strYear = date("Y",strtotime($strDate))+543;
        $strMonth= date("n",strtotime($strDate));
        $strDay= date("j",strtotime($strDate));
        $strHour= date("H",strtotime($strDate));
        $strMinute= date("i",strtotime($strDate));
        $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $strMonthThai=$strMonthCut[$strMonth];
        // return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
        return "$strDay $strMonthThai $strYear";
    }
    function percentbar($percen) { ?> 
        <div id="progressbar">
            <div style="width: <?php
                if(number_format($percen*100,2,'.',',')>=100){
                    echo '100';} else{ echo number_format($percen*100,2,'.',',');  }
                                ?>%">
            <p class="progress-label"><?php 
            if(number_format($percen*100,2,'.',',')>=100){
                echo '100.00';} else{
            echo number_format($percen*100,2,'.',',');} ?>%</p>
        </div>
    </div>
    <?php } 




?>