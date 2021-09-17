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

<div class="my-3"><h5 class="font-weight-bold text-primary"> อัตราการฉีดวัคซีนของจังหวัดพัทลุง แยกเข็ม วันที่ <?php echo DateThai2($sdate); ?></div>
<table class="table table-bordered table-sm">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <th>โรงพยาบาล</th>
        <th>อัตราการฉีด/วัน<br>เข็ม 1 (โดส)</th>
        <th>อัตราการฉีด/วัน<br>เข็ม 2 (โดส)</th>
        <th>อัตราการฉีด/วัน<br>เข็ม 3 (โดส)</th>
        <th>อัตราการฉีด/วัน<br>รวม (โดส)</th>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT TEMP2.*,
            TEMP1.rate1,
            TEMP1.rate2,
            TEMP1.rate3,
            TEMP1.rate,
            TEMP1.group31,TEMP1.group32,TEMP1.group33,TEMP1.group3,
            TEMP1.group41,TEMP1.group42,TEMP1.group43,TEMP1.group4,
            TEMP1.group81,TEMP1.group82,TEMP1.group83,TEMP1.group8,TEMP1.stotal FROM (SELECT 
                        hospital_code,ref_hospital_name,
                                    SUM(CASE WHEN vaccine_plan_no = 1 THEN Total ELSE 0 END) AS rate1,
                                    SUM(CASE WHEN vaccine_plan_no = 2 THEN Total ELSE 0 END) AS rate2,
                                    SUM(CASE WHEN vaccine_plan_no = 3 THEN Total ELSE 0 END) AS rate3,
                                    SUM(Total) AS rate,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group31,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group32,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group33,
                                                                                    SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group41,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group42,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group43,
                                                SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group81,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group82,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group83,
                                                SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                                                SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
                        FROM eoc_vaccine_dategroup_plan WHERE immunization_date = '$sdate'  GROUP BY hospital_code) AS TEMP1
                        RIGHT JOIN eoc_hospital_name_code TEMP2 ON TEMP1.hospital_code=TEMP2.hospital_code";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['ref_hospital_name'] ; ?></td>
            <td><?php echo number_format($row['rate1'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate2'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate'],0,'.',',') ; ?></td>
        <?php } ?>
    </tbody>
    <tfooter>
        <?php 
            $sql_stock_sum = "SELECT ref_hospital_name,

            SUM(CASE WHEN vaccine_plan_no = 1 THEN Total ELSE 0 END) AS rate1,
            SUM(CASE WHEN vaccine_plan_no = 2 THEN Total ELSE 0 END) AS rate2,
            SUM(CASE WHEN vaccine_plan_no = 3 THEN Total ELSE 0 END) AS rate3,
            SUM(Total) AS rate,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group31,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group32,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group33,
                                                            SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group41,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group42,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group43,
                        SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group81,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group82,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group83,
                        SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                        SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
FROM eoc_vaccine_dategroup_plan  WHERE immunization_date = '$sdate' ";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            while($row = mysqli_fetch_assoc($query_stock_sum)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo "รวม" ;  ?></td>
            <td><?php echo number_format($row['rate1'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate2'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['rate'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tfooter>

</table>

<div class="my-3"><h5 class="font-weight-bold text-primary"> การฉีดวัคซีนกลุ่มเป้าหมาย 608 วันที่ <?php echo DateThai2($sdate); ?></div>
<table class="table table-bordered table-sm">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <tr>
            <th rowspan="2">โรงพยาบาล</th>
            <th colspan="4">ผู้สูงอายุ60ปี</th>
            <th colspan="4">โรคประจำตัว</th>
            <th colspan="4">หญิงตั้งครรภ์</th>
            <th colspan="4">รวม</th>
            <th rowspan="2">ร้อยละ 608<br>เฉพาะเข็ม1</th>
            <th rowspan="2">ร้อยละ 608<br>ต่อวันรวม</th>
        </tr>
        <tr>
            <th>เข็ม1</th>
            <th>เข็ม2</th>
            <th>เข็ม3</th>
            <th>รวม</th>
            <th>เข็ม1</th>
            <th>เข็ม2</th>
            <th>เข็ม3</th>
            <th>รวม</th>
            <th>เข็ม1</th>
            <th>เข็ม2</th>
            <th>เข็ม3</th>
            <th>รวม</th>
            <th>เข็ม1</th>
            <th>เข็ม2</th>
            <th>เข็ม3</th>
            <th>รวม</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT TEMP2.*,
            TEMP1.rate1,
            TEMP1.rate2,
            TEMP1.rate3,
            TEMP1.rate,
            TEMP1.group31,TEMP1.group32,TEMP1.group33,TEMP1.group3,
            TEMP1.group41,TEMP1.group42,TEMP1.group43,TEMP1.group4,
            TEMP1.group81,TEMP1.group82,TEMP1.group83,TEMP1.group8,
            TEMP1.stotal1,TEMP1.stotal2,TEMP1.stotal3,TEMP1.stotal FROM (SELECT 
                        hospital_code,ref_hospital_name,
                                    SUM(CASE WHEN vaccine_plan_no = 1 THEN Total ELSE 0 END) AS rate1,
                                    SUM(CASE WHEN vaccine_plan_no = 2 THEN Total ELSE 0 END) AS rate2,
                                    SUM(CASE WHEN vaccine_plan_no = 3 THEN Total ELSE 0 END) AS rate3,
                                    SUM(Total) AS rate,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group31,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group32,
                                                            SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group33,
                                                                                    SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group41,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group42,
                                                            SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group43,
                                                SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group81,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group82,
                                                            SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group83,
                                                SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                                                            SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS stotal1,
															SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS stotal2,
															SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS stotal3,
                                                SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
                        FROM eoc_vaccine_dategroup_plan WHERE immunization_date = '$sdate'  GROUP BY hospital_code) AS TEMP1
                        RIGHT JOIN eoc_hospital_name_code TEMP2 ON TEMP1.hospital_code=TEMP2.hospital_code";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['ref_hospital_name'] ; ?></td>
            <td><?php echo number_format($row['group31'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group32'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group33'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group3'],0,'.',',') ; ?></td>
            
            <td><?php echo number_format($row['group41'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group42'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group43'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group4'],0,'.',',') ; ?></td>
            
            <td><?php echo number_format($row['group81'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group82'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group83'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group8'],0,'.',',') ; ?></td>

            <td><?php echo number_format($row['stotal1'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal2'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal'],0,'.',',') ; ?></td>
            <td><?php
                if($row['rate1']== NULL || $row['stotal1']== 0){ ;
                    percentbar2(0);
                }else{
                    percentbar2($row['stotal1']/$row['rate1']); }
              ?>
            </td>
            <td><?php
                if($row['rate']==NULL){ ;
                    percentbar2(0);
                }else{
                    percentbar2($row['stotal']/$row['rate']); }
              ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
        <?php 
            $sql_stock_sum = "SELECT ref_hospital_name,

            SUM(CASE WHEN vaccine_plan_no = 1 THEN Total ELSE 0 END) AS rate1,
            SUM(CASE WHEN vaccine_plan_no = 2 THEN Total ELSE 0 END) AS rate2,
            SUM(CASE WHEN vaccine_plan_no = 3 THEN Total ELSE 0 END) AS rate3,
            SUM(Total) AS rate,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group31,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group32,
                                    SUM(CASE WHEN group_number = 3 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group33,
                                                            SUM(CASE WHEN group_number = 3 THEN Total ELSE 0 END) AS group3,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group41,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group42,
                                    SUM(CASE WHEN group_number = 4 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group43,
                        SUM(CASE WHEN group_number = 4 THEN Total ELSE 0 END) AS group4,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS group81,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS group82,
                                    SUM(CASE WHEN group_number = 8 AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS group83,
                        SUM(CASE WHEN group_number = 8 THEN Total ELSE 0 END) AS group8,
                                    SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 1 THEN Total ELSE 0 END) AS stotal1,
									SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 2 THEN Total ELSE 0 END) AS stotal2,
									SUM(CASE WHEN group_number in (3,4,8) AND vaccine_plan_no = 3 THEN Total ELSE 0 END) AS stotal3,
                        SUM(CASE WHEN group_number in (3,4,8)  THEN Total ELSE 0 END) AS stotal
FROM eoc_vaccine_dategroup_plan  WHERE immunization_date = '$sdate' ";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            while($row = mysqli_fetch_assoc($query_stock_sum)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo "รวม" ; ?></td>
            <td><?php echo number_format($row['group31'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group32'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group33'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group3'],0,'.',',') ; ?></td>
            
            <td><?php echo number_format($row['group41'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group42'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group43'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group4'],0,'.',',') ; ?></td>
            
            <td><?php echo number_format($row['group81'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group82'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group83'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['group8'],0,'.',',') ; ?></td>

            <td><?php echo number_format($row['stotal1'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal2'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal3'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['stotal'],0,'.',',') ; ?></td>
            <td><?php
                if($row['rate1']==NULL){ ;
                    percentbar2(0);
                }else{
                    percentbar2($row['stotal1']/$row['rate1']); }
              ?>
            </td>
            <td><?php
                if($row['rate']==NULL){ ;
                    percentbar2(0);
                }else{
                    percentbar2($row['stotal']/$row['rate']); }
              ?>
            </td>
        </tr>
        <?php } ?>
    </tfooter>

</table>