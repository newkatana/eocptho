<?php   $sql2 = "SELECT * FROM eoc_vaccine_dategroup group by immunization_date order by immunization_date desc limit 1";
        $query2 = mysqli_query($con,$sql2);
        while($row = mysqli_fetch_assoc($query2)){
        $sdate = $row['immunization_date'];
        // $xdate = "AND eoc_vaccine_dategroup.immunization_date = '".$sdate."'";
                }
        if (!empty($_GET['sdate'])) {
            $sdate = $_GET['sdate'];
            // $xdate = "AND eoc_vaccine_dategroup.immunization_date = '".$sdate."'";
         //echo $xdate ;
        } else  ?>

<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">รายงานสถานการณ์รายวัน 608 จังหวัดพัทลุง</h4>
<h6 class="text-white">ประจำวันที่ <?php echo DateThai2($sdate);?></h6>
</div><hr>

<form method="get"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="input-group">
    <input class="d-none" name="page" value="vaccine-daily">
    <select class="form-select form-select-sm" name="sdate" id="sdate">
					<option class="align-center" value="" selected disabled>--กรุณาเลือกวันที่--</option>
                    <?php
                        $sql = "SELECT * FROM eoc_vaccine_dategroup group by immunization_date order by immunization_date desc";
                        $query = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_assoc($query)){
                    ?>
                	<option value="<?php echo $row['immunization_date']; ?>"><?php echo $row['immunization_date']; ?></option>
				<?php } ?>
    </select>
    <div class="input-group-append">
        <button class="btn btn-primary btn-sm" type="submit">
            ไป
        </button>
       </div>
    </div>
</form> 

<div class="my-3"><h5 class="font-weight-bold text-primary"> การฉีดวัคซีนกลุ่มเป้าหมาย 608 วันที่ <?php echo DateThai2($sdate); ?></div>
<table class="table table-bordered table-sm">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <th>โรงพยาบาล</th>
        <th>อัตราการฉีด/วัน<br>(โดส)</th>
        <th>ฉีด60ปี<br>(โดส)</th>
        <th>ฉีด7โรคเรื้อรัง<br>(โดส)</th>
        <th>ฉีดหญิงตั้งครรภ์<br>(โดส)</th>
        <th>ยอดฉีดกลุ่ม608<br>(โดส)</th>
        <th>ร้อยละการฉีด<br>608 ต่อวัน(โดส)</th>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "	SELECT TEMP2.*,TEMP1.rate,TEMP1.group2,TEMP1.group3,TEMP1.group4,TEMP1.group8,TEMP1.stotal FROM (SELECT 
            hospital_code,ref_hospital_name,
                        SUM(Total) AS rate,
                        SUM(CASE WHEN group_number = 2 THEN Total ELSE 0 END) AS group2,
                                    SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                                    SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                                    SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                                    SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
            FROM eoc_vaccine_dategroup WHERE immunization_date = '$sdate'  GROUP BY hospital_code) AS TEMP1
            RIGHT JOIN eoc_hospital_name_code TEMP2 ON TEMP1.hospital_code=TEMP2.hospital_code";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['ref_hospital_name'] ; ?></td>
            <td><?php echo number_format($row['rate'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group4'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group8'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal'],0,'.',',') ; ?></td>
            <td>
            <div id="progressbar">
                <div style="width: <?php
                if($row['rate']==NULL){ echo "0" ;}else{
                    if(number_format($row['stotal']/$row['rate']*100,2,'.',',')>=100){
                            echo '100';} else{ echo number_format($row['stotal']/$row['rate']*100,2,'.',',');  }
                }
                                        ?>%">
                    <p class="progress-label"><?php 
                if($row['rate']==0){ echo "0" ;}else{
                    if(number_format($row['stotal']/$row['rate']*100,2,'.',',')>=100){
                        echo '100.00';} else{
                    echo number_format($row['stotal']/$row['rate']*100,2,'.',',');}
                } ?>%</p>
                </div>
            </div>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
        <?php 
            $sql_stock_sum = "SELECT 	ref_hospital_name,
            SUM(Total) AS rate,
            SUM(CASE WHEN group_number = 2 THEN Total ELSE 0 END) AS group2,
                        SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                        SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                        SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                        SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
            FROM eoc_vaccine_dategroup
            WHERE immunization_date = '$sdate'";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            while($row = mysqli_fetch_assoc($query_stock_sum)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo "รวม" ; ?></td>
            <td><?php echo number_format($row['rate'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group4'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group8'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal'],0,'.',',') ; ?></td>
            <td><?php echo percentbar($row['stotal']/$row['rate']); ?></td>
        </tr>
        <?php } ?>
    </tfooter>

</table>