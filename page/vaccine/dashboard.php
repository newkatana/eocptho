<div class="container">
<div class="row jumbotron py-2 d-block">
        <h2>Dashboard</h2>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card border border-dark p-3">
                ฉีดวัคซีนทั้งหมด <br>
                <h4>
                    <?php 
                            $sql = "SELECT SUM(total) as totalall FROM eoc_vaccine_brand";
                            $query = mysqli_query($con,$sql);
                            while($row = mysqli_fetch_assoc($query)){
                                echo number_format($row['totalall'],0,'.',',')." โดส" ;
                            }
                    ?>
                </h4>
            </div>
        </div>
        <div class="col-md-9">
                <?php   $sql_b = "SELECT vaccine_manufacturer FROM eoc_vaccine_brand group by vaccine_manufacturer" ;
                        $query_b = mysqli_query($con,$sql_b);
                        while($row = mysqli_fetch_assoc($query_b)){
                            echo $row['vaccine_manufacturer'].'<br>';
                            $vaccine_manufacturer = $row['vaccine_manufacturer'];
                            
                            // ย่อย
                            $sql_c = "SELECT vaccine_manufacturer,vaccine_plan_no,
                                SUM(total) as totalall
                            FROM eoc_vaccine_brand where vaccine_manufacturer = '$vaccine_manufacturer'
                            group by vaccine_plan_no";
                            $query_c = mysqli_query($con,$sql_c);
                            while($row = mysqli_fetch_assoc($query_c)){
                                echo "&nbsp&nbsp&nbsp เข็ม ".$row['vaccine_plan_no']." 🔹 ".$row['totalall'].'<br>';
                            }
                        }
                ?>
        </div>
    </div>
</div>

