<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูลวัคซีนคงเหลือ จังหวัดพัทลุง</h3>
<h6 class="text-white"><span class="text-white"> ข้อมูลจาก DDC -> 
    <a class="text-white" href="https://e-reports.doe.moph.go.th/aefi"><u>https://e-reports.doe.moph.go.th/aefi</u></a>
     &nbsp&nbsp&nbsp&nbsp </span> ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
    //    echo DateThai(date($row['date']));
}$str = 'ุ63';
$int = filter_var($str, FILTER_SANITIZE_NUMBER_INT);
?> 31 สิงหาคม 2564 เวลา 9.00 น. </h6>
</div><hr>

