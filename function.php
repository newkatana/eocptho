<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P2J6NNF');</script>
<!-- End Google Tag Manager -->
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
            <div style="
                <?php 
                if($percen*100 <= 50){
                    echo "background-color: #eb7a34;";
                } else if($percen*100 <= 70){
                    echo "background-color: #e8eb34;";
                } else {
                    echo "background-color: #66ff33;";
                }
                ?> height: 20px; width: <?php
                    if(number_format($percen*100,2,'.',',')>=100){
                        echo '100';} else{ echo number_format($percen*100,2,'.',',');  }
                                    ?>%">
                <p class="progress-label"><?php 
                if(number_format($percen*100,2,'.',',')>=100){
                    echo '100.00';} else{
                echo number_format($percen*100,2,'.',',');} ?></p>
            </div>
        </div>
    <?php } 

function percentbar2($percen) { ?> 
    <div id="progressbar">
        <div style="
        <?php 
        if($percen*100 <= 50){
            echo "background-color: #eb7a34;";
        } else if($percen*100 <= 70){
            echo "background-color: #e8eb34;";
        } else {
            echo "background-color: #66ff33;";
        }
        ?> height: 20px; width: <?php
            if(number_format($percen*100,2,'.',',')>=100){
                echo '100';} else{ echo number_format($percen*100,2,'.',',');  }
                            ?>%">
        <p class="progress-label"><?php 
        if(number_format($percen*100,2,'.',',')>=100){
            echo '100.00';} else{
        echo number_format($percen*100,2,'.',',');} ?></p>
    </div>
</div>
<?php } 


// function news icon
    // datetime("2021-07-17",5);
    $numdate_news=5;
    function datetime($date_create,$date_num){
        $now = time(); // or your date as well
        $your_date = strtotime($date_create);
        $datediff = $now - $your_date;
        return (round($datediff / (60 * 60 * 24))<=$date_num) ? "<img src=\"images/new018.gif\">" : "";
    }



?>