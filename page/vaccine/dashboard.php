<style>
   
    hr{
        border-top: 1px solid blue;
    }
    /* table.table-bordered{
    border:1px solid black;
    margin-top:20px;
    }
    table.table-bordered > thead > tr > th{
        border:1px solid black;
    }
    table.table-bordered > tbody > tr > td{
        border:1px solid black;
    } */
</style>
<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูลการฉีดวัคซีน จังหวัดพัทลุง</h3>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>
</div><hr>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border border-primary p-3 py-4">
                <b>ฉีดวัคซีนทั้งหมด
                <div class="row px-3 d-flex justify-content-between">
                <h4 class="font-weight-bold text-primary ">
                    <?php 
                            $sql = "SELECT SUM(totala) as totalall FROM eoc_vaccine_brand";
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                echo number_format($row['totalall'],0,'.',',')." โดส" ;
                            }
                    ?>
                </h4><div class="d-flex align-items-center"><span class="text-dark align-bottom">
                <img src="images/greenup.svg" style="max-width:11px">
                    <?php 
                            $sql = "SELECT * FROM eoc_yesterday";
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                echo number_format($row['yesterday'],0,'.',',')." โดส" ;
                            }
                    ?>

                </span></div></div></b>
    
                <?php 
                    $sql_a = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(target) as sTarget,
                                SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                                FROM eoc_target
                                INNER JOIN eoc_vaccine_group
                                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code";
                    $result_a = mysqli_query($con, $sql_a);
                    while($row = mysqli_fetch_assoc($result_a)) { ?>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $row['sDose1']/$row['sTarget']*100; ?>%">
                            <?php echo number_format($row['sDose1']/$row['sTarget']*100,2,'.',',')."%"; ?>
                        </div>
                    </div><p class="mb-0 pb-0" style="text-align:left;">กลุ่มเป้าหมาย(100%)
                    <span style="float:right;">
                    <?php  echo number_format($row['sDose1'], 0, '.', ',')."/".number_format($row['sTarget'], 0, '.', ',')." คน";
                 } ?></span></p>
                <hr>
                <?php   $sql_b = "SELECT vaccine_manufacturer,sum(totala) as totalall FROM eoc_vaccine_brand group by vaccine_manufacturer" ;
                        $query_b = mysqli_query($con,$sql_b);
                        while($row = mysqli_fetch_assoc($query_b)){
                            echo '<b>'.$row['vaccine_manufacturer']." &nbsp".number_format($row['totalall'],0,'.',',')." &nbspโดส".'</b>';
                            $vaccine_manufacturer = $row['vaccine_manufacturer'];
                            
                            // ย่อย
                            $sql_c = "SELECT vaccine_manufacturer,vaccine_plan_no,
                                SUM(totala) as totalall
                            FROM eoc_vaccine_brand where vaccine_manufacturer = '$vaccine_manufacturer'
                            group by vaccine_plan_no";
                            $query_c = mysqli_query($con,$sql_c);
                            while($row = mysqli_fetch_assoc($query_c)){
                                echo "&nbsp&nbsp&nbsp&nbsp&nbsp เข็ม ".$row['vaccine_plan_no']." &nbsp&nbsp ".number_format($row['totalall'],0,'.',',').'<br>';
                            }
                        }
                ?>
            </div>
        </div>
        <div class="col-md-8">
                <?php require 'page/vaccine/dash-chart/vacnum.php'; ?>
        </div>
    </div>
    <div class="row">
        <div class="card-body">
                <?php  include 'page/vaccine/dash-chart/injectbydate.php';?>
        </div>
    </div>
    <div class="row">
        <div class="card-body">
                        <?php include 'dash-chart/hospitalnum.php';?>
        </div>
    </div>
        


