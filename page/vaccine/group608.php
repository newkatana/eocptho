<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">ข้อมูลสรุปกลุ่มเป้าหมาย 608 จังหวัดพัทลุง</h4>
<h6 class="text-white">ประจำวันที่ <?php echo DateThai(date("Y-m-d")); ?> เวลา 09.00 น.</h6>
</div><hr>
<div class="my-3"><h5 class="font-weight-bold text-primary"> รวมกลุ่มเป้าหมาย 608</div>
<div class="container-fluid">
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <th>โรงพยาบาล</th>
            <th>เป้าหมาย</th>
            <th>เข็ม 1</th>
            <th>ร้อยละ</th>
            <th>เข็ม 2</th>
            <th>ร้อยละ</th>
        </thead>
                <tbody>
    <?php   $sql = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN target ELSE 0 END) AS Target_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose1 ELSE 0 END) AS Dose1_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose2 ELSE 0 END) AS Dose2_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN target ELSE 0 END) AS Target_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose1 ELSE 0 END) AS Dose1_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose2 ELSE 0 END) AS Dose2_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN target ELSE 0 END) AS Target_preg,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose1 ELSE 0 END) AS Dose1_preg,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose2 ELSE 0 END) AS Dose2_preg
                FROM eoc_target
                INNER JOIN eoc_vaccine_group
                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
                group by ref_hospital_name ORDER BY hospital_code"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){; 
                $Target608 = $row['Target_elder']+$row['Target_disease']+$row['Target_preg'];
                $dose1 =  $row['Dose1_elder']+$row['Dose1_disease']+$row['Dose1_preg'];
                $dose2 =  $row['Dose2_elder']+$row['Dose2_disease']+$row['Dose2_preg'];
            ?>
            <tr class="text-center">
                    <td class="text-left"><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
                    <td><?php echo number_format($Target608,0,'.',','); ?></td>
                    <td><?php echo number_format($dose1,0,'.',','); ?></td>
                    <td><?php percentbar($dose1/$Target608); ?></td>
                    <td><?php echo number_format($dose2,0,'.',','); ?></td>
                    <td><?php percentbar($dose2/$Target608); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN target ELSE 0 END) AS Target_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose1 ELSE 0 END) AS Dose1_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose2 ELSE 0 END) AS Dose2_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN target ELSE 0 END) AS Target_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose1 ELSE 0 END) AS Dose1_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose2 ELSE 0 END) AS Dose2_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN target ELSE 0 END) AS Target_preg,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose1 ELSE 0 END) AS Dose1_preg,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose2 ELSE 0 END) AS Dose2_preg
                        FROM eoc_target
                        INNER JOIN eoc_vaccine_group
                        ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){; 
                    $Target608 = $row['Target_elder']+$row['Target_disease']+$row['Target_preg'];
                    $dose1 =  $row['Dose1_elder']+$row['Dose1_disease']+$row['Dose1_preg'];
                    $dose2 =  $row['Dose2_elder']+$row['Dose2_disease']+$row['Dose2_preg'];
                ?>
                <tr class="text-center">
                        <td class="text-center"><?php echo "รวม"; ?></td>
                        <td><?php echo number_format($Target608,0,'.',','); ?></td>
                        <td><?php echo number_format($dose1,0,'.',','); ?></td>
                        <td><?php percentbar($dose1/$Target608); ?></td>
                        <td><?php echo number_format($dose2,0,'.',','); ?></td>
                        <td><?php percentbar($dose2/$Target608); ?></td>
                    </tr>
                    <?php   };?>
            </tfooter>
        </table>
</div>




<div class="my-3"><h5 class="font-weight-bold text-primary"> เป้าหมาย 608 แยกกลุ่ม</div>
<div class="container-fluid">
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <tr>
                <th rowspan="2">โรงพยาบาล</th>
                <th colspan="5">ผู้สูงอายุ</th>
                <th colspan="5">ผู้ป่วยโรคเรื้อรัง</th>
                <th colspan="5">หญิงตั้งครรภ์</th>
            </tr>
            <tr>
                <th>เป้าหมาย</th>
                <th>เข็ม 1</th>
                <th>ร้อยละ</th>
                <th>เข็ม 2</th>
                <th>ร้อยละ</th>
                <th>เป้าหมาย</th>
                <th>เข็ม 1</th>
                <th>ร้อยละ</th>
                <th>เข็ม 2</th>
                <th>ร้อยละ</th>
                <th>เป้าหมาย</th>
                <th>เข็ม 1</th>
                <th>ร้อยละ</th>
                <th>เข็ม 2</th>
                <th>ร้อยละ</th>
            </tr>
        </thead>
                <tbody>
    <?php   $sql = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN target ELSE 0 END) AS Target_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose1 ELSE 0 END) AS Dose1_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose2 ELSE 0 END) AS Dose2_elder,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN target ELSE 0 END) AS Target_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose1 ELSE 0 END) AS Dose1_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose2 ELSE 0 END) AS Dose2_disease,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN target ELSE 0 END) AS Target_preg,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose1 ELSE 0 END) AS Dose1_preg,
                SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose2 ELSE 0 END) AS Dose2_preg
                FROM eoc_target
                INNER JOIN eoc_vaccine_group
                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
                group by ref_hospital_name ORDER BY hospital_code"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){; ?>
            <tr class="text-center">
                    <td class="text-left"><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
                    <td><?php echo number_format($row['Target_elder'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_elder'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_elder']/$row['Target_elder']); ?></td>
                    <td><?php echo number_format($row['Dose2_elder'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_elder']/$row['Target_elder']); ?></td>
                    <td><?php echo number_format($row['Target_disease'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_disease'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_disease']/$row['Target_disease']); ?></td>
                    <td><?php echo number_format($row['Dose2_disease'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_disease']/$row['Target_disease']); ?></td>
                    <td><?php echo number_format($row['Target_preg'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_preg'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_preg']/$row['Target_preg']); ?></td>
                    <td><?php echo number_format($row['Dose2_preg'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_preg']/$row['Target_preg']); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN target ELSE 0 END) AS Target_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose1 ELSE 0 END) AS Dose1_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 3 THEN Dose2 ELSE 0 END) AS Dose2_elder,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN target ELSE 0 END) AS Target_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose1 ELSE 0 END) AS Dose1_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 4 THEN Dose2 ELSE 0 END) AS Dose2_disease,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN target ELSE 0 END) AS Target_preg,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose1 ELSE 0 END) AS Dose1_preg,
                        SUM(CASE WHEN eoc_vaccine_group.group_number = 8 THEN Dose2 ELSE 0 END) AS Dose2_preg
                        FROM eoc_target
                        INNER JOIN eoc_vaccine_group
                        ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){ ?>
                <tr class="text-center">
                <td class="text-center"><?php  echo "รวม"; ?></td>
                    <td><?php echo number_format($row['Target_elder'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_elder'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_elder']/$row['Target_elder']); ?></td>
                    <td><?php echo number_format($row['Dose2_elder'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_elder']/$row['Target_elder']); ?></td>
                    <td><?php echo number_format($row['Target_disease'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_disease'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_disease']/$row['Target_disease']); ?></td>
                    <td><?php echo number_format($row['Dose2_disease'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_disease']/$row['Target_disease']); ?></td>
                    <td><?php echo number_format($row['Target_preg'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1_preg'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1_preg']/$row['Target_preg']); ?></td>
                    <td><?php echo number_format($row['Dose2_preg'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2_preg']/$row['Target_preg']); ?></td>
                </tr>
                <?php   };?>
            </tfooter>
        </table>
</div>