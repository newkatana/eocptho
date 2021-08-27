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
<h6 class="text-white">ประจำวันที่ <?php echo DateThai(date("Y-m-d")); ?> เวลา 09.00 น.</h6>
</div><hr>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border border-primary p-3 py-4">
                <b>ฉีดวัคซีนทั้งหมด
                <h4 class="font-weight-bold text-primary">
                    <?php 
                            $sql = "SELECT SUM(total) as totalall FROM eoc_vaccine_brand";
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                echo number_format($row['totalall'],0,'.',',')." โดส" ;
                            }
                    ?>
                </h4></b><hr>
                <?php   $sql_b = "SELECT vaccine_manufacturer,sum(total) as totalall FROM eoc_vaccine_brand group by vaccine_manufacturer" ;
                        $query_b = mysqli_query($con,$sql_b);
                        while($row = mysqli_fetch_assoc($query_b)){
                            echo '<b>'.$row['vaccine_manufacturer']." &nbsp".number_format($row['totalall'],0,'.',',')." &nbspโดส".'</b>';
                            $vaccine_manufacturer = $row['vaccine_manufacturer'];
                            
                            // ย่อย
                            $sql_c = "SELECT vaccine_manufacturer,vaccine_plan_no,
                                SUM(total) as totalall
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
                        <?php include 'dash-chart/hospitalnum.php';?>
        </div>
    </div>
        


