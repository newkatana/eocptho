<br>
<div class="">
    อาการไม่พึงประสงค์
</div>
<hr>
<div class="">
    อาการไม่พึงประสงค์ ช่วงเวลา 30 นาที
</div>
<div class="col-6">
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
                FROM immunization_aefi_observe 
                group by vaccine_reaction_symptom_name
                order by total desc";
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