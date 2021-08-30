<?php 
$sql2 = "SELECT * FROM vaccine_stock group by datadate order by datadate desc limit 1";
$query2 = mysqli_query($con,$sql2);
while($row = mysqli_fetch_assoc($query2)){
    $sdate = $row['datadate'];
            }
    if (!empty($_GET['sdate'])) {
        $sdate = $_GET['sdate'];
    // echo $sdate ;
    } else 
 ?>
<style>
        .total-stock{
            position: absolute;
            top: 270px ;
            left: 900px;
            font-size: 60px;
        }
        .date-stock{
            position: absolute;
            top: 223px ;
            left: 1035px;
            font-size: 25px;
        }
        .table-stock{
            position: absolute;
            top: 450px ;
            left: 320px;
            font-size: 20px;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 350px;
        }
        .table-stock tr th,
        .table-stock tr td {
        border-right: 3px solid #ffffff;
        border-bottom: 3px solid #ffffff;
        padding: 5px;
        }
        .table-stock tr th:first-child,
        .table-stock tr td:first-child {
        border-left: 3px solid #ffffff;
        }
        .table-stock tr th {
        background: linear-gradient(to top left, #662d90 0%, #37184e 100%);
        border-top: 3px solid #ffffff;
        text-align: left;
        }
        /* top-left border-radius */
        .table-stock tr:first-child th:first-child {
        border-top-left-radius: 12px;
        }

        /* top-right border-radius */
        .table-stock tr:first-child th:last-child {
        border-top-right-radius: 12px;
        }

        /* bottom-left border-radius */
        .table-stock tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
        }

        /* bottom-right border-radius */
        .table-stock tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
        }
</style>

<form method="get"  name="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="input-group">
    <input class="d-none" name="page" value="stock">
    <select class="form-control form-control-sm" name="sdate" id="sdate" onchange="this.form.submit()" >
					<option class="align-center" value="" selected disabled>--กรุณาเลือกวันที่--</option>
                    <?php
                        $sql = "SELECT * FROM vaccine_stock group by datadate order by datadate desc";
                        $query = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_assoc($query)){
                    ?>
                	<option value="<?php echo $row['datadate']; ?>"><?php echo $row['datadate']; ?></option>
				<?php } ?>
    </select>
    </div>
</form> 
        <img src="page/stock/bgstock.jpg" alt="bg" style="width: 1200px;">
        <div class="total-stock text-white">
        <?php
                $sql = "SELECT * FROM vaccine_stock where datadate = '$sdate' and hospital_name ='รวม'";
                $query = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($query)){
                    echo number_format((float)($row['instock']), 0, '', ',');
                }
        ?>
        </div>
        <div class="date-stock text-black" style="min-width: 300px">
            <?php echo $sdate; ?>
        </div>
        <!-- table  -->
            <table class="table-stock">
                <thead class="text-white " style="height:60px">
                    <th class="text-center" style="min-width: 340px">โรงพยาบาล</th>
                    <th class="text-center" style="min-width: 120px">ยอดรับวัคซีน</th>
                    <th class="text-center" style="min-width: 120px">คงเหลือ</th>
                    <th class="text-center" style="min-width: 120px">เปอร์เซนต์</th>
                    <th class="text-center" style="min-width: 120px; background: linear-gradient(to top left, #ff0066 0%, #ffcccc 100%);">Sinovac</th>
                    <th class="text-center" style="min-width: 120px; background: linear-gradient(to top left, #ff6600 0%, #ffcccc 100%);">Aztrazeneca</th>
                    <th class="text-center" style="min-width: 120px; background: linear-gradient(to top left, #3333cc 0%, #99ccff 100%);">Pfizer</th>
                </thead>
                <tbody class="text-end" style="height:600px; ">
                <?php
                    $sql3 = "SELECT hospital_name,income,instock,round(instock/income*100,2) as percent,vaccine_sv,vaccine_az,vaccine_pf FROM `vaccine_stock` WHERE datadate = '$sdate'";
                    $query3 = mysqli_query($con,$sql3);
                    while($row = mysqli_fetch_assoc($query3)){ ?>
                    <tr style="background: #e6e6e6;">
                        <td class="text-start" ><?php echo $row['hospital_name'];?></td>
                        <td><?php echo number_format((float)($row['income']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['instock']), 0, '', ',');?></td>
                        <td class="align-top"><?php echo $row['percent']."%";?> <br>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $row['percent'];?>% ; background: #662D90;" role="progressbar" aria-valuenow="<?php echo $row['percent'];?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            </td>
                        <td style="background: #ffccdd;"><?php echo number_format((float)($row['vaccine_sv']), 0, '', ',');?></td>
                        <td style="background: #ffddcc;"><?php echo number_format((float)($row['vaccine_az']), 0, '', ',');?></td>
                        <td style="background: #cce6ff;"><?php echo number_format((float)($row['vaccine_pf']), 0, '', ',');?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfooter>

                </tfooter>
            </table>


