<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ยอดวัคซีนคงเหลือรายวัน จังหวัดพัทลุง</h3>
<!-- <h6 class="text-white">ประจำวันที่ -->
    <?php  
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
     //   echo DateThai(date($row['date']));
}

?></h6>
</div><hr>

<?php 
$sql2 = "SELECT * FROM vaccine_stock2 group by datadate order by datadate desc limit 1";
$query2 = mysqli_query($con,$sql2);
while($row = mysqli_fetch_assoc($query2)){
    $sdate = $row['datadate'];
            }
    if (!empty($_GET['sdate'])) {
        $sdate = $_GET['sdate'];
    // echo $sdate ;
    } else 
?>
<form method="get"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="input-group">
    <input class="d-none" name="page" value="inventory">
    <select class="form-select form-select-sm" name="sdate" id="sdate">
					<option class="align-center" value="" selected disabled>--กรุณาเลือกวันที่--</option>
                    <?php
                        $sql = "SELECT * FROM vaccine_stock2 group by datadate order by datadate desc";
                        $query = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_assoc($query)){
                    ?>
                	<option value="<?php echo $row['datadate']; ?>"><?php echo $row['datadate']; ?></option>
				<?php } ?>
    </select>
    <div class="input-group-append">
        <button class="btn btn-primary btn-sm" type="submit">
            ไป
        </button>
       </div>
    </div>
</form> 
<br>
<b><h5 class="text-primary"><?php echo DateThai2($sdate)." เวลา 16.00 น.";?></h5></b>
<?php $sql_stock_sum = "SELECT 
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
            where datadate = '$sdate'";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            $vaccine_total;
            while($row = mysqli_fetch_assoc($query_stock_sum)){
                $vaccine_total = number_format($row['s_instock'],0,'.',',');}?>
<center><div class="col-md-5 col-sm-12 card m-4 pt-4 pb-3" style="background: linear-gradient(to bottom right, #0000ff 0%, #33ccff 100%">
    <h5 class="font-weight-bold text-white"><?php echo "ยอดวัคซีนคงเหลือ ".$vaccine_total." โดส"; ?></h5></div></center>
<table class="table table-bordered table-sm" id="invent">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <th>โรงพยาบาล</th>
        <th>จำนวนรับวัคซีน( Dose)</th>
        <th>วัคซีนคงเหลือ (Dose)</th>
        <th>Sinovac</th>
        <th>AstraZeneca</th>
        <th>Sinopharm</th>
        <th>Pfizer</th>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT * FROM vaccine_stock2 WHERE datadate = '$sdate' order by number";
            $query_stock = mysqli_query($con,$sql_stock);
            while($row = mysqli_fetch_assoc($query_stock)){?>
        <tr class="text-right">
            <td class="text-left"><?php echo $row['hospital_name'] ; ?></td>
            <td><?php echo number_format($row['income'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['instock'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['vaccine_pz'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
        <?php 
            $sql_stock_sum = "SELECT 
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
            where datadate = '$sdate'";
            $query_stock_sum = mysqli_query($con,$sql_stock_sum);
            while($row = mysqli_fetch_assoc($query_stock_sum)){?>
        <tr class="text-right">
            <td class="text-center"><?php echo "รวม" ; ?></td>
            <td><?php echo number_format($row['s_income'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_instock'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['s_vaccine_pz'],0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tfooter>

</table>