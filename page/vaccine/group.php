<style>
    </style>
<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">ข้อมูลสรุปกลุ่มเป้าหมายฉีดวัคซีน จังหวัดพัทลุง</h4>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>
</div><hr>
<div class="container-fluid">
    <table class="table table-sm  rounded table-bordered">
            <thead class="text-center" style="background-color:#f2f2f2;">
                <tr>
                    <th rowspan="2">กลุ่มเป้าหมาย</th>
                    <th rowspan="2">เป้าหมาย</th>
                    <th colspan="2">เข็ม 1 (โดส)</th>
                    <th colspan="2">เข็ม 2 (โดส)</th>
                    <th colspan="2">เข็ม 3 (โดส)</th>
                    <th rowspan="2">รวม (โดส)</th>
                </tr>
                <tr>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                </tr>
            </thead>
            <tbody>
        <?php $sql_group_a = "SELECT eoc_vaccine_group.group_number,eoc_vaccine_group.person_type_name,
                SUM(target) as starget,SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                FROM eoc_vaccine_group
                INNER JOIN eoc_target
                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code 
                group by eoc_vaccine_group.person_type_name  order by eoc_vaccine_group.group_number";
                $query_group_a = mysqli_query($con,$sql_group_a);
                while($row = mysqli_fetch_assoc($query_group_a)){ ?>
                <tr class="text-right">
                    <td class="text-left"><?php  echo $row['person_type_name']; ?></td>
                    <td><?php echo number_format($row['starget'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['sDose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose1']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose2']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose3'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose3']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sTotal'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT eoc_vaccine_group.group_number,eoc_vaccine_group.person_type_name,
                                SUM(target) as starget,SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                                FROM eoc_vaccine_group
                                INNER JOIN eoc_target
                                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){ ?>
                <tr class="text-right">
                    <td class="text-right"><?php  echo "รวม"; ?></td>
                    <td><?php echo number_format($row['starget'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['sDose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose1']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose2']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose3'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose3']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sTotal'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tfooter>
        </table>
    </div>

<div class="container-fluid">
        <?php 
                $sql_group_c = "SELECT * FROM eoc_vaccine_group group by person_type_name order by group_number";
                $query_group_c = mysqli_query($con,$sql_group_c);

                $round=0;
                while($row = mysqli_fetch_assoc($query_group_c)){ 
                    $round++;
                    $i = $row['person_type_name'];
                    echo '<div class="my-3"><h5 class="font-weight-bold text-primary">'.$row['person_type_name'].'</h5></div>';?>

        <table class="table table-sm  rounded table-bordered">
            <thead class="text-center" style="background-color:#f2f2f2;">
                <tr>
                    <th rowspan="2">กลุ่มเป้าหมาย</th>
                    <th rowspan="2">เป้าหมาย</th>
                    <th colspan="2">เข็ม 1 (โดส)</th>
                    <th colspan="2">เข็ม 2 (โดส)</th>
                    <th colspan="2">เข็ม 3 (โดส)</th>
                    <th rowspan="2">รวม (โดส)</th>
                </tr>
                <tr>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>ร้อยละ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // $sql_group = "SELECT * FROM eoc_vaccine_group where person_type_name = '$i' group by ref_hospital_name  order by hospital_code";
                    $sql_group = "SELECT * 
                    FROM eoc_vaccine_group
                    INNER JOIN eoc_target
                    ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code 
                    where eoc_vaccine_group.person_type_name = '$i'
                    group by eoc_vaccine_group.ref_hospital_name  order by eoc_vaccine_group.hospital_code";

                    $query_group = mysqli_query($con,$sql_group);
                    while($row = mysqli_fetch_assoc($query_group)){ 
                    ?>
                    
                <tr class="text-right">
                    <td class="text-left"><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
                    <td><?php echo number_format($row['target'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['Dose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose1']/$row['target']); ?></td>
                    <td><?php echo number_format($row['Dose2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose2']/$row['target']); ?></td>
                    <td><?php echo number_format($row['Dose3'],0,'.',','); ?></td>
                    <td><?php percentbar($row['Dose3']/$row['target']); ?></td>
                    <td><?php echo number_format($row['Total'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php 
                    // $sql_group = "SELECT * FROM eoc_vaccine_group where person_type_name = '$i' group by ref_hospital_name  order by hospital_code";
                    $sql_group = "SELECT SUM(target)as starget,SUM(Dose1)as sDose1,SUM(Dose2)as sDose2,SUM(Dose3)as sDose3,SUM(Total)as sTotal
                    FROM eoc_vaccine_group
                    INNER JOIN eoc_target
                    ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code 
                    where eoc_vaccine_group.person_type_name = '$i'";
                    $query_group = mysqli_query($con,$sql_group);
                    while($row = mysqli_fetch_assoc($query_group)){ ?>
                <tr class="text-right">
                    <td class="text-right"><?php echo "รวม"; ?></td>
                    <td><?php echo number_format($row['starget'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['sDose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose1']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose2']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose3'],0,'.',','); ?></td>
                    <td><?php percentbar($row['sDose3']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sTotal'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tfooter>
        </table>
        
        <div class="row">
            <div class="card-body">
                            <?php
                            include 'dash-chart/hospital_type.php';
                            ?>
            </div>
        </div>

        <hr>

        <?php } ?>
    </div>