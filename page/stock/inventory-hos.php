<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ยอดวัคซีนคงเหลือสะสม แยกรายโรงพยาบาล จังหวัดพัทลุง</h3>
<h6 class="text-white">ข้อมูลจาก MOPH-IC ประจำวันที่
    <?php  
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
    echo DateThai(date($row['date']));
}
?></h6>
</div><hr>
<?php 
$vacbrand = '10747'; 
$visit = array(
	"10747" => "โรงพยาบาลพัทลุง",
    "11414" => "โรงพยาบาลกงหรา",
    "11415" => "โรงพยาบาลเขาชัยสน",
    "11416" => "โรงพยาบาลตะโหมด",
    "11417" => "โรงพยาบาลควนขนุน",
    "11418" => "โรงพยาบาลปากพะยูน",
    "11419" => "โรงพยาบาลศรีบรรพต",
    "11420" => "โรงพยาบาลป่าบอน",
    "11421" => "โรงพยาบาลบางแก้ว",
    "11422" => "โรงพยาบาลป่าพะยอม",
    "24673" => "โรงพยาบาลศรีนครินทร์");
// echo $tableweek;
if (isset($_GET['vacbrand'])) {

$vacbrand = $_GET['vacbrand'];

//  echo $vacbrand;
};
?>

<form method="get"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row container input-group mb-3">
    <input class="d-none" name="page" value="inventory-hos">
    <select class="form-select form-select-sm" name="vacbrand" id="vacbrand" >
					<option class="align-center" value="%%" selected disabled>--กรุณาเลือกโรงพยาบาล--</option>
				<?php foreach($visit as $x=>$x_value){ ?>
                	<option value="<?php echo $x; ?>"><?php echo $x_value; ?></option>
				<?php } ?>
    </select>
       <div class="input-group-append">
        <button class="btn btn-primary btn-sm" type="submit">
            ไป
        </button>
       </div>
    </div>
</form> 

<?php 
$sql_hos = "SELECT ref_hospital_name,hospital_code,sum(totala) 
                FROM eoc_vaccine_brand 
                WHERE hospital_code = $vacbrand
                GROUP BY ref_hospital_name order by hospital_code";
$query_hos = mysqli_query($con,$sql_hos);
while($row = mysqli_fetch_assoc($query_hos)){
    echo $row['ref_hospital_name'];
                    } ?>
<table class="table table-bordered table-sm" id="invent-hos">
    <thead class="text-center" style="background-color:#f2f2f2;">
        <tr>
            <th rowspan="2" style="min-width: 100px;">วันที่</th>
            <th colspan="6">SV</th>
            <th colspan="6">AZ</th>
            <th colspan="6">PZ</th>
            <th colspan="6">SP</th>
        </tr>
        <tr>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
            <th>รับ</th>
            <th>ฉีด</th>
            <th>รับสะสม</th>
            <th>ฉีดสะสม</th>
            <th>เสียสะสม</th>
            <th>เหลือ</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sql_stock = "SELECT * 
            FROM
            (SELECT * FROM eoc_allday) t1 
            LEFT JOIN
            (SELECT movement_date,hospital_code,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 7 THEN movement_dose ELSE 0 END) AS recieve_sv,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 1 THEN movement_dose ELSE 0 END) AS recieve_az,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 6 THEN movement_dose ELSE 0 END) AS recieve_pz,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 1 AND vaccine_manufacturer_id = 8 THEN movement_dose ELSE 0 END) AS recieve_sp,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 7 THEN movement_dose ELSE 0 END) AS broke_sv,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 1 THEN movement_dose ELSE 0 END) AS broke_az,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 6 THEN movement_dose ELSE 0 END) AS broke_pz,
                    SUM(CASE WHEN vaccine_inventory_movement_type_id = 3 AND vaccine_manufacturer_id = 8 THEN movement_dose ELSE 0 END) AS broke_sp,
                    SUM(movement_dose) AS recieve_all
                    FROM vaccine_inventory_movement 
                    WHERE hospital_code = $vacbrand
                    GROUP BY hospital_code,movement_date) t2
            ON t1.alldate = t2.movement_date
            LEFT JOIN
            (SELECT immunization_date,hospital_code,
                    SUM(CASE WHEN vaccine_manufacturer_id = 7 THEN 1 ELSE 0 END) AS inject_sv,
                    SUM(CASE WHEN vaccine_manufacturer_id = 1 THEN 1 ELSE 0 END) AS inject_az,
                    SUM(CASE WHEN vaccine_manufacturer_id = 6 THEN 1 ELSE 0 END) AS inject_pz,
                    SUM(CASE WHEN vaccine_manufacturer_id = 8 THEN 1 ELSE 0 END) AS inject_sp,
                    COUNT(*) AS inject_all
                    FROM visit_immunization 
                    WHERE hospital_code = $vacbrand
                    GROUP BY hospital_code,immunization_date) t3
            ON t1.alldate = t3.immunization_date";
            $query_stock = mysqli_query($con,$sql_stock);
                $recieve_sv = 0;
                $recieve_az = 0;
                $recieve_pz = 0;
                $recieve_sp = 0;
                $inject_sv = 0;
                $inject_az = 0;
                $inject_pz = 0;
                $inject_sp = 0;
                $broke_sv = 0;
                $broke_az = 0;
                $broke_pz = 0;
                $broke_sp = 0;
            while($row = mysqli_fetch_assoc($query_stock)){
                $recieve_sv += $row['recieve_sv'];
                $inject_sv += $row['inject_sv'];
                $broke_sv += $row['broke_sv'];
                $recieve_az += $row['recieve_az'];
                $inject_az += $row['inject_az'];
                $broke_az += $row['broke_az'];
                $recieve_pz += $row['recieve_pz'];
                $inject_pz += $row['inject_pz'];
                $broke_pz += $row['broke_pz'];
                $recieve_sp += $row['recieve_sp'];
                $inject_sp += $row['inject_sp'];
                $broke_sp += $row['broke_sp'];
                ?>
        <tr class="text-right">
            <td class="text-center"><?php echo $row['alldate'] ; ?></td>
            <td><?php echo number_format($row['recieve_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_sv'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sv-$inject_sv-$broke_sv,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_az'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_az-$inject_az-$broke_az,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_pz'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_pz'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_pz-$inject_pz-$broke_pz,0,'.',',') ; ?></td>
            <td><?php echo number_format($row['recieve_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($row['inject_sp'],0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($inject_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($broke_sp,0,'.',',') ; ?></td>
            <td><?php echo number_format($recieve_sp-$inject_sp-$broke_sp,0,'.',',') ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfooter>
    </tfooter>

</table>