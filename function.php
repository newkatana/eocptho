<?php
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
        <p class="progress-label"><?php echo number_format($percen*100,2,'.',',')."%"; ?></p>
    </div>
</div>
<?php } 


?>