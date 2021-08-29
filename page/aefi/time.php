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

<?php 
$vacbrand = ''; 
$visit = array(
	"WHERE vaccine_manufacturer_id = 1" => "AstraZeneca",
	"WHERE vaccine_manufacturer_id = 6" => "Pfizer, BioNTech",
	"WHERE vaccine_manufacturer_id = 7" => "Sinovac Life Sciences",
	"WHERE vaccine_manufacturer_id = 8" => "Sinopharm");
// echo $tableweek;
if (isset($_POST['vacbrand'])) {

$vacbrand = $_POST['vacbrand'];

//  echo $vacbrand;
};
?>

<form method="post"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row container input-group mb-3">
    <input class="d-none" name="page" value="aefi-time">
    <select class="form-select form-select-sm" name="vacbrand" id="vacbrand" >
					<option class="align-center" value="%%" selected disabled>--กรุณาเลือกยี่ห้อวัคซีน--</option>
					<option class="align-center" value="">วัคซีนรวม</option>  
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
<?php $sql_vac_sum = "SELECT vaccine_manufacturer_id,vaccine_manufacturer,sum(totala) 
                        FROM eoc_vaccine_brand 
                        $vacbrand
                        GROUP BY vaccine_manufacturer_id order by vaccine_manufacturer_id";
                    $query_vac_sum = mysqli_query($con,$sql_vac_sum);
                    $azsum = 0;$pzsum = 0;$svsum = 0;$spsum = 0;
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
                  } 
                  $totalsum = $azsum+$pzsum+$svsum+$spsum ;
                  echo "รวม ".number_format($totalsum,0,'.',',')." โดส";
                  ?>
<hr>
<div class="container-extend">
<h6 class="text-primary">ตารางแสดงอาการไม่พึงประสงค์แยกตามเวลาที่เกิดอาการ (*ร้อยละ ของยอดฉีดวัคซีนแต่ละยี่ห้อ)</h6>
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
                                $vacbrand
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
            <td class="align-middle"><?php percentbar($row['total']/$totalsum); ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>