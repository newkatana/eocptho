<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูล AEFI-DDC จังหวัดพัทลุง</h3>
<h6 class="text-white"><span class="text-white"> ข้อมูลจาก DDC -> 
    <a class="text-white" href="https://e-reports.doe.moph.go.th/aefi"><u>https://e-reports.doe.moph.go.th/aefi</u></a>
     &nbsp&nbsp&nbsp&nbsp </span>ข้อมูล ณ วันที่ 13 กันยายน 2564 เวลา 14.00 น.<?php 
    // $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    // WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    // $query_time = mysqli_query($con,$datadate);
    // while($row = mysqli_fetch_assoc($query_time)){
    //    echo DateThai(date($row['date']));}
$str = 'ุ63';
$int = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
?> 
</h6>
</div><hr>
    <table class="table table-sm  rounded table-bordered">
        <thead class="text-center" style="background-color:#f2f2f2;">
            <th>โรงพยาบาลที่รับการรักษา</th>
            <th>AEFI 1 (คน)</th>
            <th>AEFI 2 (คน)</th>
        </thead>
                <tbody>
    <?php   $sql = "SELECT hospital_treatment,count(*) AS saefi1,
                    SUM(CASE WHEN aefi2 = 1 THEN 1 ELSE 0 END) as saefi2
                    FROM eoc_aefi_ddc  GROUP BY hospital_treatment 
                    ORDER BY saefi1 desc , hospital_treatment asc"; 
            $query = mysqli_query($con,$sql);
            while($row = mysqli_fetch_assoc($query)){; 
            ?>
            <tr class="text-center">
                    <td class="text-left"><?php 
                    if($row['hospital_treatment']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['hospital_treatment']; ?></td>
                    <td><?php echo number_format($row['saefi1'],0,'.',','); ?></td>
                    <td><?php echo number_format($row['saefi2'],0,'.',','); ?></td>
                </tr>
                <?php   };?>
            </tbody>
            <tfooter>
            <?php $sql_group_b = "SELECT hospital_treatment,count(*) AS saefi1,
                    SUM(CASE WHEN aefi2 = 1 THEN 1 ELSE 0 END) as saefi2
                    FROM eoc_aefi_ddc";
                $query_group_b = mysqli_query($con,$sql_group_b);
                while($row = mysqli_fetch_assoc($query_group_b)){; 
                ?>
                <tr class="text-center">
                        <td class="text-center"><?php echo "รวม"; ?></td>
                        <td><?php echo number_format($row['saefi1'],0,'.',','); ?></td>
                        <td><?php echo number_format($row['saefi2'],0,'.',','); ?></td>
                    </tr>
                    <?php   };?>
            </tfooter>
    </table>
