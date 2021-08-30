<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">สรุปรวมยอดวัคซีนคงเหลือ จังหวัดพัทลุง</h3>
<h6 class="text-white">ณ เวลา 16.00 น. ของทุกวัน
    <?php  
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
     //   echo DateThai(date($row['date']));
}

?></h6>
</div><hr>

<table class="table table-bordered table-sm" id="invent-summary">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <th>วันที่</th>
        <th>จำนวนรับวัคซีน( Dose)</th>
        <th>วัคซีนคงเหลือ (Dose)</th>
        <th>Sinovac</th>
        <th>AstraZeneca</th>
        <th>Sinopharm</th>
        <th>Pfizer</th>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT 
            number,hospital_code,hospital_name,province,
            sum(income) as s_income,
            sum(instock) as s_instock,
            sum(vaccine_sv) as s_vaccine_sv,
            sum(vaccine_az) as s_vaccine_az,
            sum(vaccine_sp) as s_vaccine_sp,
            sum(vaccine_pz) as s_vaccine_pz,
            datadate 
            FROM 
            vaccine_stock2
	GROUP BY datadate ORDER BY datadate desc";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo $row['datadate'] ; ?></td>
            <td><?php echo number_format($row['s_income'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_instock'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_pz'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
    </tfooter>

</table>