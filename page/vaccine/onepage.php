<div style="width: 900px;">
<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white text-center">การดำเนินการให้วัคซีน COVID-19 จังหวัดพัทลุง</h4>
<h6 class="text-white text-center">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai2(date($row['date']));
} 
?> เวลา 09.00 น.</h6>
</div>
<div class="mt-2 my-3"><h5 class="font-weight-bold text-primary text-center">แยกตามกลุ่มเป้าหมาย</h5></div>

<div class="container-extend">
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
                    <td><?php percentbar2($row['sDose1']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose2'],0,'.',','); ?></td>
                    <td><?php percentbar2($row['sDose2']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose3'],0,'.',','); ?></td>
                    <td><?php percentbar2($row['sDose3']/$row['starget']); ?></td>
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
                    <td><?php percentbar2($row['sDose1']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose2'],0,'.',','); ?></td>
                    <td><?php percentbar2($row['sDose2']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sDose3'],0,'.',','); ?></td>
                    <td><?php percentbar2($row['sDose3']/$row['starget']); ?></td>
                    <td><?php echo number_format($row['sTotal'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tfooter>
        </table>
    </div>

<div class="mt-2 my-3"><h5 class="font-weight-bold text-primary text-center">แยกตามหน่วยบริการฉีดวัคซีน</h5></div>
<div class="container-extend mb-3 pb-4">
<table class="table table-sm table-bordered">
<thead class="text-center" style="background-color:#f2f2f2;">
  <tr>
    <th rowspan="2">โรงพยาบาล</th>
    <th rowspan="2">เป้าหมาย(คน)</th>
    <th rowspan="2">อัตราการฉีด<br>(โดส/วัน)</th>
    <th rowspan="2">ยอดจอง<br>(คิว)</th>
    <th colspan="2">เข็ม 1 (โดส)</th>
    <th colspan="2">เข็ม 2 (โดส)</th>
    <th colspan="2">เข็ม 3 (โดส)</th>
    <th rowspan="2">รวม 3 เข็ม <br> (โดส)</th>
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
    $sql_table = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(eoc_target.target) as sTarget,eoc_target.rate,eoc_ratetarget.queue,eoc_ratetarget.slot,
                SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                FROM eoc_target
                INNER JOIN eoc_vaccine_group
                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
                INNER JOIN eoc_ratetarget
                ON eoc_vaccine_group.hospital_code = eoc_ratetarget.hospital_code
                group by eoc_vaccine_group.ref_hospital_name ORDER BY hospital_code";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
          <td><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
          <td class="text-right"><?php echo number_format($row['sTarget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['rate'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['queue']+$row['slot'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose1']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose2']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose3']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sTotal'], 0, '.', ','); ?></td>
          </tr>
        <?php }; ?>
    <tbody>
    <tfooter>
    <?php 
    $sql_table = "SELECT 
    sum(queue) as squeue,sum(rate) as srate,sum(xd) as starget,sum(slot) as sslot,sum(sDose1) as x1,sum(sDose2) as x2,sum(sDose3) as x3,sum(sTotal) as xtotal
    FROM 
        (SELECT * FROM eoc_ratetarget) t1
    INNER JOIN
        (SELECT hospital_code,SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal FROM eoc_vaccine_group
    group by eoc_vaccine_group.hospital_code) t2 
    ON t1.hospital_code = t2.hospital_code 
    INNER JOIN
        (SELECT sum(eoc_target.target) as xd,hospital_code FROM eoc_target group by hospital_code) t3
    ON t1.hospital_code = t3.hospital_code
    ";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
        <td class="text-center"><?php echo "รวม"; ?></td>
          <td class="text-right"><?php echo number_format($row['starget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['srate'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['squeue']+$row['sslot'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['x1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x1']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['x2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x2']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['x3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x3']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['xtotal'], 0, '.', ','); ?></td>
          </tr>
        <?php }; ?>   
    </tfooter>
</table>
</div>

<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h6 class="text-white text-center"><img src="images/qrweb.png" class="float-left" style="position: absolute; transform: translate(-150%, -60%); width:100px;">ติดต่อสอบถาม สำนักงานสาธารณสุขจังหวัดพัทลุง โทร.074-623127 ต่อ 400,401,305</h6>
<h6 class="text-white text-center mb-0 pb-0">ที่มา : ข้อมูล MOPH-Immunization Center</h6>
</div>
</div>
