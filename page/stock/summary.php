<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ยอดวัคซีนคงเหลือรวม จังหวัดพัทลุง</h3>
<h6 class="text-white">ข้อมูลจาก MOPH-IC ประจำวันที่
    <?php  
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
      echo DateThai(date($row['date']));
}
?></h6>
</div><hr>

<table class="table table-bordered table-sm table-hover" id="invent-summary">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <tr>
            <th rowspan="2" style="min-width: 100px;">วันที่</th>
            <th colspan="6">SV</th>
            <th colspan="6">AZ</th>
            <th colspan="6">PZ</th>
            <th colspan="6">SP</th>
            <th colspan="6">Total</th>
        </tr>
        <tr>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT * 
            FROM
            (SELECT * FROM eoc_allday) t1 
            LEFT JOIN
            (SELECT movement_date,hospital_code,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 7 THEN movement_dose ELSE 0 END) AS recieve_sv,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 1 THEN movement_dose ELSE 0 END) AS recieve_az,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 6 THEN movement_dose ELSE 0 END) AS recieve_pz,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 8 THEN movement_dose ELSE 0 END) AS recieve_sp,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 7 THEN movement_dose ELSE 0 END) AS broke_sv,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 1 THEN movement_dose ELSE 0 END) AS broke_az,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 6 THEN movement_dose ELSE 0 END) AS broke_pz,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 8 THEN movement_dose ELSE 0 END) AS broke_sp,
                    SUM(movement_dose) AS recieve_all
                    FROM vaccine_inventory_movement 
                    GROUP BY movement_date) t2
            ON t1.alldate = t2.movement_date
            LEFT JOIN
            (SELECT immunization_date,hospital_code,
                    SUM(CASE WHEN vaccine_manufacturer_id = 7 THEN 1 ELSE 0 END) AS inject_sv,
                    SUM(CASE WHEN vaccine_manufacturer_id = 1 THEN 1 ELSE 0 END) AS inject_az,
                    SUM(CASE WHEN vaccine_manufacturer_id = 6 THEN 1 ELSE 0 END) AS inject_pz,
                    SUM(CASE WHEN vaccine_manufacturer_id = 8 THEN 1 ELSE 0 END) AS inject_sp,
                    COUNT(*) AS inject_all
                    FROM visit_immunization 
                    GROUP BY immunization_date) t3
            ON t1.alldate = t3.immunization_date
            ORDER BY t1.alldate asc ";
            $query_stock = mysqli_query($con,$sql_stock);
                $recieve_sv = 0;
                $recieve_az = 0;
                $recieve_pz = 0;
                $recieve_sp = 0;
                $inject_sv = 0;
                $inject_az = 0;
                $inject_pz = 0;
                $inject_sp = 0;
                $broke_sv = 0;
                $broke_az = 0;
                $broke_pz = 0;
                $broke_sp = 0;
            while($row = mysqli_fetch_assoc($query_stock)){
                $recieve_sv += $row['recieve_sv'];
                $inject_sv += $row['inject_sv'];
                $broke_sv += $row['broke_sv'];
                $recieve_az += $row['recieve_az'];
                $inject_az += $row['inject_az'];
                $broke_az += $row['broke_az'];
                $recieve_pz += $row['recieve_pz'];
                $inject_pz += $row['inject_pz'];
                $broke_pz += $row['broke_pz'];
                $recieve_sp += $row['recieve_sp'];
                $inject_sp += $row['inject_sp'];
                $broke_sp += $row['broke_sp'];
                ?>
        <tr class="text-right">
            <td class="text-center"><?php echo $row['alldate'] ; ?></td>
            <td><?php echo number_format($row['recieve_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_sv,0,'.',',') ; ?></td>
            <td style="background-color:#f2f2f2;"><?php echo number_format($recieve_sv-$inject_sv-$broke_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_az,0,'.',',') ; ?></td>
            <td style="background-color:#f2f2f2;"><?php echo number_format($recieve_az-$inject_az-$broke_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_pz'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_pz'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_pz,0,'.',',') ; ?></td>
            <td style="background-color:#f2f2f2;"><?php echo number_format($recieve_pz-$inject_pz-$broke_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_sp,0,'.',',') ; ?></td>
            <td style="background-color:#f2f2f2;"><?php echo number_format($recieve_sp-$inject_sp-$broke_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_sv']+$row['recieve_az']+$row['recieve_pz']+$row['recieve_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_sv']+$row['inject_az']+$row['inject_pz']+$row['inject_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sv+$recieve_az+$recieve_pz+$recieve_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_sv+$inject_az+$inject_pz+$inject_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_sv+$broke_az+$broke_pz+$broke_sp,0,'.',',') ; ?></td>
            <td style="background-color:#f2f2f2;"><?php echo number_format(($recieve_sv+$recieve_az+$recieve_pz+$recieve_sp)-($inject_sv+$inject_az+$inject_pz+$inject_sp)-($broke_sv+$broke_az+$broke_pz+$broke_sp),0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
    </tfooter>

</table>