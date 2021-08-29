<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">ข้อมูลอาการไม่พึงประสงค์แยกโรงพยาบาล จังหวัดพัทลุง</h4>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>
</div><hr>

<?php 
$vacbrand = ''; 
$visit = array(
	"AND hospital_code = 10747" => "โรงพยาบาลพัทลุง",
    "AND hospital_code = 11414" => "โรงพยาบาลกงหรา",
    "AND hospital_code = 11415" => "โรงพยาบาลเขาชัยสน",
    "AND hospital_code = 11416" => "โรงพยาบาลตะโหมด",
    "AND hospital_code = 11417" => "โรงพยาบาลควนขนุน",
    "AND hospital_code = 11418" => "โรงพยาบาลปากพะยูน",
    "AND hospital_code = 11419" => "โรงพยาบาลศรีบรรพต",
    "AND hospital_code = 11420" => "โรงพยาบาลป่าบอน",
    "AND hospital_code = 11421" => "โรงพยาบาลบางแก้ว",
    "AND hospital_code = 11422" => "โรงพยาบาลป่าพะยอม",
    "AND hospital_code = 24673" => "โรงพยาบาลศรีนครินทร์");
// echo $tableweek;
if (isset($_GET['vacbrand'])) {

$vacbrand = $_GET['vacbrand'];

//  echo $vacbrand;
};
?>

<form method="get"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row container input-group mb-3">
    <input class="d-none" name="page" value="aefi-hos">
    <select class="form-select form-select-sm" name="vacbrand" id="vacbrand" >
					<option class="align-center" value="%%" selected disabled>--กรุณาเลือกโรงพยาบาล--</option>
					<option class="align-center" value="">โรงพยาบาลทั้งหมด</option>  
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
<h6 class="text-primary">ยอดฉีดวัคซีน</h6>
<?php 
$vacbrand2 = '';
if(strpos($vacbrand, 'AND') !== false) {
    $vacbrand2 = "WHERE ".substr($vacbrand,3);
    //  echo $vacbrand2;
}
    $sql_vac_sum = "SELECT ref_hospital_name,hospital_code,sum(totala) 
                        FROM eoc_vaccine_brand 
                        $vacbrand2
                        GROUP BY ref_hospital_name order by hospital_code";
                    $query_vac_sum = mysqli_query($con,$sql_vac_sum);
$h10747 = 0;$h11414 = 0;$h11415 = 0;$h11416 = 0;$h11417 = 0;$h11418 = 0;$h11419 = 0;$h11420 = 0;$h11421 = 0;$h11422 = 0;$h24673 = 0;
                    while($row = mysqli_fetch_assoc($query_vac_sum)){
                        if($row['hospital_code']==10747){
                            $h10747 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11414){
                            $h11414 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11415){
                            $h11415 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11416){
                            $h11416 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11417){
                            $h11417 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11418){
                            $h11418 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11419){
                            $h11419 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11420){
                            $h11420 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11421){
                            $h11421 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==11422){
                            $h11422 = $row['sum(totala)'];
                        }
                        if($row['hospital_code']==24673){
                            $h24673 = $row['sum(totala)'];
                        }
                     echo   $row['ref_hospital_name']." ".number_format($row['sum(totala)'],0,'.',',').' โดส<br>';
                  } 
                  $totalsum = $h10747+$h11414+$h11415+$h11416+$h11417+$h11418+$h11419+$h11420+$h11421+$h11422+$h24673 ;
                  echo "รวม ".number_format($totalsum,0,'.',',')." โดส";
                  ?>
<hr>
<div class="container-extend">
<h6 class="text-primary">ตารางแสดงอาการไม่พึงประสงค์แยกตามโรงพยาบาล เวลาเกิดอาการ และยี่ห้อวัคซีน (*ร้อยละ ของยอดฉีดวัคซีนแต่ละยี่ห้อ ของโรงพยาบาลที่เลือก)</h6>
<?php
    $sql_brand = "SELECT vaccine_manufacturer_id,vaccine_manufacturer,sum(totala) 
                    FROM eoc_vaccine_brand 
                    $vacbrand2
                    GROUP BY vaccine_manufacturer_id order by vaccine_manufacturer_id";
    $query_brand = mysqli_query($con,$sql_brand);
    $vac_i;
    while($rowa = mysqli_fetch_assoc($query_brand)){
        $vac_i = $rowa['vaccine_manufacturer_id']; 
        echo '<h6 class="text-primary">'.$rowa['vaccine_manufacturer'].'<span class="text-dark"> '.number_format($rowa['sum(totala)'],0,'.',',').' โดส</span></h6>';
        ?>
    <table class="table table-sm rounded table-bordered">
    <thead class="text-center">
        <tr>
            <th scope="col" class="text-center">อาการ</th>
            <th scope="col">observe</th>
            <th scope="col">Day1</th>
            <th scope="col">Day7</th>
            <th scope="col">Day30</th>
            <th scope="col">รวม</th>
            <th scope="col">ร้อยละ</th>
        </tr>
    </thead>
    <tbody>
    <?php $sql_aefia = "SELECT  eoc_aefi_observe.vaccine_reaction_symptom_id,eoc_aefi_observe.vaccine_reaction_symptom_name_th,
                                eoc_aefi_observe.vaccine_reaction_symptom_name_en,
                                SUM(CASE WHEN eoc_aefi_observe.followup_day_no = 'observe' THEN total ELSE 0 END) AS observe,
                                SUM(CASE WHEN eoc_aefi_observe.followup_day_no = 1 THEN total ELSE 0 END) AS day1,
                                SUM(CASE WHEN eoc_aefi_observe.followup_day_no = 7 THEN total ELSE 0 END) AS day7,
                                SUM(CASE WHEN eoc_aefi_observe.followup_day_no = 30 THEN total ELSE 0 END) AS day30,
                                SUM(total) as total
                                FROM eoc_aefi_observe
								WHERE vaccine_manufacturer_id = $vac_i.$vacbrand
                                group by eoc_aefi_observe.vaccine_reaction_symptom_id
                                order by total desc";
                    $query_aefia = mysqli_query($con,$sql_aefia);
                    while($row = mysqli_fetch_assoc($query_aefia)){ ?>
        <tr class="text-center align-middle">
            <td class="text-left"><?php echo $row['vaccine_reaction_symptom_name_th']." (".$row['vaccine_reaction_symptom_name_en'].")"; ?></td>
            <td class="align-middle"><?php echo number_format($row['observe'],0,'.',','); ?></td>
            <td class="align-middle"><?php echo number_format($row['day1'],0,'.',','); ?></td>
            <td class="align-middle"><?php echo number_format($row['day7'],0,'.',','); ?></td>
            <td class="align-middle"><?php echo number_format($row['day30'],0,'.',','); ?></td>
            <td class="align-middle"><?php echo number_format($row['total'],0,'.',','); ?></td>
            <td class="align-middle"><?php percentbar($row['total']/$rowa['sum(totala)']); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
</div>