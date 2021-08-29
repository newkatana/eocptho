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
<h6 class="text-primary">ยอดฉีดวัคซีน</h6>
<?php $sql_vac_sum = "SELECT vaccine_manufacturer_id,vaccine_manufacturer,sum(totala) 
                        FROM eoc_vaccine_brand 
                        GROUP BY vaccine_manufacturer_id order by vaccine_manufacturer_id";
                    $query_vac_sum = mysqli_query($con,$sql_vac_sum);
                    $azsum;$pzsum;$svsum;$spsum;
                    while($row = mysqli_fetch_assoc($query_vac_sum)){
                        if($row['vaccine_manufacturer_id']==1){
                            $azsum = $row['sum(totala)'];
                        }
                        if($row['vaccine_manufacturer_id']==6){
                            $pzsum = $row['sum(totala)'];
                        }
                        if($row['vaccine_manufacturer_id']==7){
                            $svsum = $row['sum(totala)'];
                        }
                        if($row['vaccine_manufacturer_id']==8){
                            $spsum = $row['sum(totala)'];
                        }
                     echo   $row['vaccine_manufacturer']." ".number_format($row['sum(totala)'],0,'.',',').' โดส<br>';
                  } $totalsum = $azsum+$pzsum+$svsum+$spsum ; ?>
<hr>
<div class="container-extend">
<h6 class="text-primary">ตารางแสดงอาการไม่พึงประสงค์แยกตามยี่ห้อวัคซีน (*ร้อยละ ของยอดฉีดวัคซีนแต่ละยี่ห้อ)</h6>
    <table class="table table-sm rounded table-bordered">
    <thead class="text-center">
        <tr>
            <th scope="col" class="text-center" rowspan="2">อาการ</th>
            <th scope="col" colspan="2">AstraZeneca</th>
            <th scope="col" colspan="2">Pfizer, BioNTech</th>
            <th scope="col" colspan="2">Sinovac Life Sciences</th>
            <th scope="col" colspan="2">Sinopharm</th>
            <th scope="col" colspan="2">รวม</th>
        </tr>
        <tr>
            <th scope="col">จำนวน</th>
            <th scope="col">ร้อยละ</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ร้อยละ</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ร้อยละ</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ร้อยละ</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ร้อยละ</th>
        </tr>
    </thead>
    <tbody>
    <?php $sql_aefia = "SELECT  eoc_aefi_observe.vaccine_reaction_symptom_id,eoc_aefi_observe.vaccine_reaction_symptom_name_th,
                        eoc_aefi_observe.vaccine_reaction_symptom_name_en,
                        SUM(CASE WHEN eoc_aefi_observe.vaccine_manufacturer_id = 1 THEN total ELSE 0 END) AS AZ,
                        SUM(CASE WHEN eoc_aefi_observe.vaccine_manufacturer_id = 6 THEN total ELSE 0 END) AS PZ,
                        SUM(CASE WHEN eoc_aefi_observe.vaccine_manufacturer_id = 7 THEN total ELSE 0 END) AS SV,
                        SUM(CASE WHEN eoc_aefi_observe.vaccine_manufacturer_id = 8 THEN total ELSE 0 END) AS SP,
                        SUM(total) as total
                        FROM eoc_aefi_observe
                        group by eoc_aefi_observe.vaccine_reaction_symptom_id
                        order by total desc";
                    $query_aefia = mysqli_query($con,$sql_aefia);
                    while($row = mysqli_fetch_assoc($query_aefia)){ ?>
        <tr class="text-center align-middle">
            <td class="text-left"><?php echo $row['vaccine_reaction_symptom_name_th']." (".$row['vaccine_reaction_symptom_name_en'].")"; ?></td>
            <td class="align-middle"><?php echo number_format($row['AZ'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['AZ']/$azsum); ?></td>
            <td class="align-middle"><?php echo number_format($row['PZ'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['PZ']/$pzsum); ?></td>
            <td class="align-middle"><?php echo number_format($row['SV'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['SV']/$svsum); ?></td>
            <td class="align-middle"><?php echo number_format($row['SP'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['SP']/$spsum); ?></td>
            <td class="align-middle"><?php echo number_format($row['total'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['total']/$totalsum); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>



</div>
<div>
    <?php //include 'stack-chart.php'; ?>
</div>

<div>
<h6 class="text-primary">อาการอื่น ๆ</h6>
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