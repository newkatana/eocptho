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
<?php $sql_aefib = "SELECT vaccine_manufacturer_id,vaccine_manufacturer,sum(totala) 
                        FROM eoc_vaccine_brand 
                        GROUP BY vaccine_manufacturer_id order by vaccine_manufacturer_id";
                    $query_aefib = mysqli_query($con,$sql_aefib);
                    while($row = mysqli_fetch_assoc($query_aefib)){
                     echo   $row['vaccine_manufacturer']." ".number_format($row['sum(totala)'],0,'.',',').' โดส<br>';
                    }?>
                    <hr>
<div class="container-extend">
    <table class="table table-sm">
    <thead>
        <tr>
        <th scope="col">อาการ</th>
        <th scope="col"style="text-align:left;">
            ยี่ห้อวัคซีน
            <span style="float:right;">
                จำนวน(ร้อยละของการฉีดวัคซีนยี่ห้อนั้นๆ)
            </span>
        </th>
        <th scope="col">รวม</th>
        </tr>
    </thead>
    <tbody>
    <?php $sql_aefia = "SELECT vaccine_manufacturer_id,vaccine_reaction_symptom_name_th,vaccine_reaction_symptom_id,
                vaccine_reaction_symptom_name_en,
                SUM(total) as total 
                FROM eoc_aefi_observe
                group by vaccine_reaction_symptom_id
                order by total desc";
                    $query_aefia = mysqli_query($con,$sql_aefia);
                    $i;
                    while($row = mysqli_fetch_assoc($query_aefia)){
                    $i = $row['vaccine_reaction_symptom_id'];
                        ?>
        <tr>
            <td><?php echo $row['vaccine_reaction_symptom_name_th'].'<br>'."(".$row['vaccine_reaction_symptom_name_en'].")"; ?></td>
            <td>
            <table class="table table-sm">
                <thead>
                </thead>
                <tbody>
                        <?php $sql_manu = "SELECT  eoc_aefi_observe.vaccine_manufacturer_id,eoc_aefi_observe.vaccine_manufacturer,SUM(total) as total,stotal
                                            FROM eoc_aefi_observe
                                            LEFT JOIN eoc_sumbrand
                                            ON eoc_aefi_observe.vaccine_manufacturer_id = eoc_sumbrand.vaccine_manufacturer_id
                                            where eoc_aefi_observe.vaccine_reaction_symptom_id = '$i'
                                            group by eoc_aefi_observe.vaccine_manufacturer_id
                                            order by eoc_aefi_observe.vaccine_manufacturer_id";
                            $query_manu = mysqli_query($con,$sql_manu);
                            while($rowa = mysqli_fetch_assoc($query_manu)){?>
                        <tr>
                            <td><?php echo $rowa['vaccine_manufacturer'];?></td>
                            <td class="text-right"><?php echo $rowa['total']." (".number_format($rowa['total']/$rowa['stotal']*100,2,'.',',')." %".")";?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </td>
            <td><?php echo $row['total']; ?></td>
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