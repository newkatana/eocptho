<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูลความครอบคลุมประชากรเข็ม1(1,3) กลุ่มเป้าหมาย 608 จังหวัดพัทลุง</h3>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>
</div><hr>

<div class="my-3 container-extend"><h5 class="font-weight-bold text-primary"> ความครอบคลุมกลุ่มเป้าหมาย 608</div>
<div class="container-extend">
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <th>อำเภอ</th>
            <th>เป้าหมาย</th>
            <th>เข็ม 1</th>
            <th>ร้อยละ</th>
            <th>เข็ม 2</th>
            <th>ร้อยละ</th>
        </thead>
                <tbody>
    <?php   $sql = "SELECT t2.ampurname,t1.* FROM
                        (SELECT discode,
                        SUM(elderly) as elderly,
                        SUM(elderly_plan_1) AS elderly_plan_1,
                        SUM(elderly_plan_2)  AS elderly_plan_2,
                        SUM(7disease) as 7disease,
                        SUM(7disease_plan_1) AS 7disease_plan_1,
                        SUM(7disease_plan_2)  AS 7disease_plan_2 ,
                        SUM(prenatal) as prenatal,
                        SUM(prenatal_plan_1) AS prenatal_plan_1,
                        SUM(prenatal_plan_2)  AS prenatal_plan_2 
                        FROM _TEMP_VAC_CORPORATE 
                        GROUP BY discode) t1
                        INNER JOIN
                        (SELECT ampurcodefull,ampurname FROM eoc_village GROUP BY ampurcodefull) t2
                        ON t1.discode = t2.ampurcodefull"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){; 
                $Target608 = $row['elderly']+$row['7disease']+$row['prenatal'];
                $dose1 =  $row['elderly_plan_1']+$row['7disease_plan_1']+$row['prenatal_plan_1'];
                $dose2 =  $row['elderly_plan_2']+$row['7disease_plan_2']+$row['prenatal_plan_2'];
            ?>
            <tr class="text-center">
                    <td class="text-left"><?php echo $row['ampurname']; ?></td>
                    <td><?php echo number_format($Target608,0,'.',','); ?></td>
                    <td><?php echo number_format($dose1,0,'.',','); ?></td>
                    <td><?php percentbar($dose1/$Target608); ?></td>
                    <td><?php echo number_format($dose2,0,'.',','); ?></td>
                    <td><?php percentbar($dose2/$Target608); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT t2.ampurname,t1.* FROM
                                    (SELECT discode,
                                    SUM(elderly) as elderly,
                                    SUM(elderly_plan_1) AS elderly_plan_1,
                                    SUM(elderly_plan_2)  AS elderly_plan_2,
                                    SUM(7disease) as 7disease,
                                    SUM(7disease_plan_1) AS 7disease_plan_1,
                                    SUM(7disease_plan_2)  AS 7disease_plan_2 ,
                                    SUM(prenatal) as prenatal,
                                    SUM(prenatal_plan_1) AS prenatal_plan_1,
                                    SUM(prenatal_plan_2)  AS prenatal_plan_2 
                                    FROM _TEMP_VAC_CORPORATE) t1
                                    INNER JOIN
                                    (SELECT ampurcodefull,ampurname FROM eoc_village GROUP BY ampurcodefull) t2
                                    ON t1.discode = t2.ampurcodefull";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){; 
                    $Target608 = $row['elderly']+$row['7disease']+$row['prenatal'];
                    $dose1 =  $row['elderly_plan_1']+$row['7disease_plan_1']+$row['prenatal_plan_1'];
                    $dose2 =  $row['elderly_plan_2']+$row['7disease_plan_2']+$row['prenatal_plan_2'];
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


<div class="my-3 container-extend"><h5 class="font-weight-bold text-primary"> ความครอบคลุมเป้าหมาย 608 แยกกลุ่ม</div>
<div class="container-extend">
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <tr>
                <th rowspan="2">อำเภอ</th>
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
    <?php   $sql = "SELECT t2.ampurname,t1.* FROM
                        (SELECT discode,
                        SUM(elderly) as elderly,
                        SUM(elderly_plan_1) AS elderly_plan_1,
                        SUM(elderly_plan_2)  AS elderly_plan_2,
                        SUM(7disease) as 7disease,
                        SUM(7disease_plan_1) AS 7disease_plan_1,
                        SUM(7disease_plan_2)  AS 7disease_plan_2 ,
                        SUM(prenatal) as prenatal,
                        SUM(prenatal_plan_1) AS prenatal_plan_1,
                        SUM(prenatal_plan_2)  AS prenatal_plan_2 
                        FROM _TEMP_VAC_CORPORATE 
                        GROUP BY discode) t1
                        INNER JOIN
                        (SELECT ampurcodefull,ampurname FROM eoc_village GROUP BY ampurcodefull) t2
                        ON t1.discode = t2.ampurcodefull"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){; ?>
            <tr class="text-center">
                    <td class="text-left"><?php echo $row['ampurname']; ?></td>
                    <td><?php echo number_format($row['elderly'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['elderly_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['elderly_plan_1']/$row['elderly']); ?></td>
                    <td><?php echo number_format($row['elderly_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['elderly_plan_2']/$row['elderly']); ?></td>
                    <td><?php echo number_format($row['7disease'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['7disease_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['7disease_plan_1']/$row['7disease']); ?></td>
                    <td><?php echo number_format($row['7disease_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['7disease_plan_2']/$row['7disease']); ?></td>
                    <td><?php echo number_format($row['prenatal'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['prenatal_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['prenatal_plan_1']/$row['prenatal']); ?></td>
                    <td><?php echo number_format($row['prenatal_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['prenatal_plan_2']/$row['prenatal']); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT t2.ampurname,t1.* FROM
                                    (SELECT discode,
                                    SUM(elderly) as elderly,
                                    SUM(elderly_plan_1) AS elderly_plan_1,
                                    SUM(elderly_plan_2)  AS elderly_plan_2,
                                    SUM(7disease) as 7disease,
                                    SUM(7disease_plan_1) AS 7disease_plan_1,
                                    SUM(7disease_plan_2)  AS 7disease_plan_2 ,
                                    SUM(prenatal) as prenatal,
                                    SUM(prenatal_plan_1) AS prenatal_plan_1,
                                    SUM(prenatal_plan_2)  AS prenatal_plan_2 
                                    FROM _TEMP_VAC_CORPORATE) t1
                                    INNER JOIN
                                    (SELECT ampurcodefull,ampurname FROM eoc_village GROUP BY ampurcodefull) t2
                                    ON t1.discode = t2.ampurcodefull";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){ ?>
                <tr class="text-center">
                <td class="text-center"><?php  echo "รวม"; ?></td>
                    <td><?php echo number_format($row['elderly'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['elderly_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['elderly_plan_1']/$row['elderly']); ?></td>
                    <td><?php echo number_format($row['elderly_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['elderly_plan_2']/$row['elderly']); ?></td>
                    <td><?php echo number_format($row['7disease'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['7disease_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['7disease_plan_1']/$row['7disease']); ?></td>
                    <td><?php echo number_format($row['7disease_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['7disease_plan_2']/$row['7disease']); ?></td>
                    <td><?php echo number_format($row['prenatal'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['prenatal_plan_1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['prenatal_plan_1']/$row['prenatal']); ?></td>
                    <td><?php echo number_format($row['prenatal_plan_2'],0,'.',','); ?></td>
                    <td><?php percentbar($row['prenatal_plan_2']/$row['prenatal']); ?></td>
                </tr>
                <?php   };?>
            </tfooter>
        </table>
</div>


