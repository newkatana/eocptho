<?php   $sql2 = "SELECT * FROM eoc_vaccine_dategroup group by immunization_date order by immunization_date desc limit 1";
        $query2 = mysqli_query($con,$sql2);
        while($row = mysqli_fetch_assoc($query2)){
        $sdate = $row['immunization_date'];
                }
        if (!empty($_GET['sdate'])) {
            $sdate = $_GET['sdate'];
        // echo $sdate ;
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

<?php //echo $sdate;?>

<div class="my-3"><h5 class="font-weight-bold text-primary"> วัคซีนคงเหลือวันที่ <?php echo DateThai2($sdate); ?></div>
<table class="table table-bordered table-sm">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <th>โรงพยาบาล</th>
        <th>จำนวนรับวัคซีน( Dose)</th>
        <th>วัคซีนคงเหลือ (Dose)</th>
        <th>Sinovac</th>
        <th>AstraZeneca</th>
        <th>Sinopharm</th>
        <th>Pfizer</th>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT * FROM eoc_vaccine_stock WHERE datadate = '$sdate' order by number";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['hospital_name'] ; ?></td>
            <td><?php echo number_format($row['income'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['instock'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_pz'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
        <?php 
            $sql_stock_sum = "SELECT 
            number,hospital_code,hospital_name,province,
            sum(income) as s_income,
            sum(instock) as s_instock,
            sum(vaccine_sv) as s_vaccine_sv,
            sum(vaccine_az) as s_vaccine_az,
            sum(vaccine_sp) as s_vaccine_sp,
            sum(vaccine_pz) as s_vaccine_pz,
            datadate 
            FROM 
            eoc_vaccine_stock
            where datadate = '$sdate'";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            while($row = mysqli_fetch_assoc($query_stock_sum)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo "รวม" ; ?></td>
            <td><?php echo number_format($row['s_income'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_instock'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_pz'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tfooter>

</table>
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
            $sql_stock = "SELECT 	ref_hospital_name,
            SUM(Total) AS rate,
            SUM(CASE WHEN group_number = 2 THEN Total ELSE 0 END) AS group2,
                        SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                        SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                        SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                        SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
            FROM eoc_vaccine_dategroup
            WHERE immunization_date = '$sdate'
            GROUP BY hospital_code";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['ref_hospital_name'] ; ?></td>
            <td><?php echo number_format($row['rate'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group4'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group8'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal'],0,'.',',') ; ?></td>
            <td><?php echo percentbar($row['stotal']/$row['rate']); ?></td>
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