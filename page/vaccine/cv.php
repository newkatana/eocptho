<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูลความครอบคลุมประชากร เข็ม 1 ตามทะเบียนราษฏร์จังหวัดพัทลุง</h3>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>

</div><hr>

<div class="my-3 container-extend"><h5 class="font-weight-bold text-primary">ข้อมูลความครอบคลุมประชากร เข็ม 1 ตามทะเบียนราษฏร์จังหวัดพัทลุง</div>
<div class="container-extend">
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <tr>
                    <th rowspan="2">อำเภอ</th>
                    <th colspan="3">ประชากรชาย</th>
                    <th colspan="3">ประชากรหญิง</th>
                    <th colspan="3">ประชากรรวม</th>
            </tr>
            <tr>
                    <th>จำนวน</th>
                    <th>เข็ม 1</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>เข็ม 1</th>
                    <th>ร้อยละ</th>
                    <th>จำนวน</th>
                    <th>เข็ม 1</th>
                    <th>ร้อยละ</th>
            </tr>
        </thead>
                <tbody>
    <?php   $sql = "SELECT t2.*,t1.dose1_male,t1.dose1_female,t1.dose1 FROM
                        (SELECT LEFT (vhid,4) as ampur ,
                        sum(case when sex = 1 then 1 else 0 end) as dose1_male,
                        sum(case when sex = 2 then 1 else 0 end) as dose1_female,
                        count(*) as dose1 
                        from cv_person_1 group by ampur ORDER BY ampur) t1
                        INNER JOIN 
                        (SELECT * FROM cv_mahadthai) t2
                        ON t1.ampur = t2.ampurcode"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){;?>
            <tr class="text-center">
                    <td class="text-left"><?php echo $row['ampurname']; ?></td>
                    <td><?php echo number_format($row['male'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1_male'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1_male']/$row['male']); ?></td>
                    <td><?php echo number_format($row['female'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1_female'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1_female']/$row['female']); ?></td>
                    <td><?php echo number_format($row['totalall'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1']/$row['totalall']); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT sum(t2.male) as male ,sum(t2.female) as female,sum(t2.totalall) as totalall,sum(t1.dose1_male) as dose1_male,sum(t1.dose1_female) as dose1_female,sum(t1.dose1) as dose1 FROM
                                    (SELECT LEFT (vhid,4) as ampur ,
                                    sum(case when sex = 1 then 1 else 0 end) as dose1_male,
                                    sum(case when sex = 2 then 1 else 0 end) as dose1_female,
                                    count(*) as dose1 
                                    from cv_person_1 group by ampur ORDER BY ampur) t1
                                    INNER JOIN 
                                    (SELECT * FROM cv_mahadthai) t2
                                    ON t1.ampur = t2.ampurcode";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){; ?>
                <tr class="text-center">
                        <td class="text-center"><?php echo "รวม"; ?></td>
                    <td><?php echo number_format($row['male'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1_male'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1_male']/$row['male']); ?></td>
                    <td><?php echo number_format($row['female'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1_female'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1_female']/$row['female']); ?></td>
                    <td><?php echo number_format($row['totalall'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['dose1'],0,'.',','); ?></td>
                    <td><?php percentbar($row['dose1']/$row['totalall']); ?></td>
                    </tr>
                    <?php   };?>
            </tfooter>
        </table>
</div>

<h6>ที่มา : สำนักทะเบียนราษฏร์ กระทรวงมหาดไทย *ประชากร ณ วันที่ 1 ม.ค. 2564</h6>
<h6>และข้อมูลการฉีดวัคซีน จาก MOPH Immunization Center </h6>