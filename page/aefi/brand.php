<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">ข้อมูลอาการไม่พึงประสงค์แยกตามยี่ห้อวัคซีน จังหวัดพัทลุง</h4>
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
    <table class="table table-sm">
    <thead>
        <tr>
        <th scope="col">อาการ</th>
        <th scope="col">จำนวน</th>
        <th scope="col">ร้อยละ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT vaccine_reaction_symptom_name,count(*) as total 
                FROM eoc_aefi_observe 
                group by vaccine_reaction_symptom_id
                order by vaccine_reaction_symptom_id asc";
        $query = mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $row['vaccine_reaction_symptom_name'];?></td>
            <td><?php echo $row['total'];?></td>
            <td><?php echo number_format($row['total']/20000*100,2,'.',',')."%";?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div>
    <?php //include 'stack-chart.php'; ?>
</div>

<div>
<span class="badge btn-primary">อาการอื่น ๆ</span>
    <table id="hosanother" class="table table-sm">
    <thead class="p-0">
        <tr>
            <th scope="col">โรงพยาบาล</th>
            <th scope="col">ประเภท</th>
            <th scope="col">กลุ่มเป้าหมาย</th>
            <th scope="col">รายละเอียด</th>
        </tr>
    </thead>
    <tbody class="p-0">
        <?php
        $sql = "SELECT ref_hospital_name,person_type_name,person_risk_type_name,reaction_detail_text
        FROM immunization_aefi_observe 
        where vaccine_reaction_symptom_id = 10";
        $query = mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <td><?php echo $row['ref_hospital_name'];?></td>
            <td><?php echo $row['person_type_name'];?></td>
            <td><?php echo $row['person_risk_type_name'];?></td>
            <td><?php echo $row['reaction_detail_text'];?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>