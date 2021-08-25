<style>
    .showdate{
        position: absolute;
        top: 141px ;
        left: 810px;
        font-size: 24px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
    .total-all{
        position: absolute;
        top: 209px ;
        left: 1120px;
        font-size: 50px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
    .total-all2{
        position: absolute;
        top: 250px ;
        left: 900px;
        font-size: 50px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
    .total-all3{
        position: absolute;
        top: 282px ;
        left: 900px;
        font-size: 20px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
    .total-all4{
        position: absolute;
        top: 280px ;
        left: 1330px;
        font-size: 20px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
    .table-stat{
        position: absolute;
        top: 760px ;
        left: 511px;
        font-size: 18px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 902px;
        max-width: 902px;
    }
    .table-stat tr th,
    .table-stat tr td {
    border-right: 0px solid #ffffff;
    border-bottom: 0px solid #ffffff;
    padding: 5px;
    }
    .table-stat tr th:first-child,
    .table-stat tr td:first-child {
    border-left: 0px ;
    }
    .table-stat tr th {
    /* background: linear-gradient(to top left, #662d90 0%, #37184e 100%); */
    border-top: 1px;
    text-align: left;
    }
    .table-stat2{
        position: absolute;
        top: 315px ;
        left: 780px;
        font-size: 18px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 632px;
        max-width: 632px;
    }
    .table-stat2 tr th,
    .table-stat2 tr td {
    border-right: 0px solid #ffffff;
    border-bottom: 0px solid #ffffff;
    padding: 5px;
    }
    .table-stat2 tr th:first-child,
    .table-stat2 tr td:first-child {
    border-left: 0px solid #ffffff;
    }
    .table-stat2 tr th {
    /* background: linear-gradient(to top left, #662d90 0%, #37184e 100%); */
    border-top: 0px solid #ffffff;
    text-align: left;
    }
    .chart-vaccine{
        position: absolute;
        top: 210px ;
        left: 280px;
        font-size: 18px;
        border-collapse: separate;
        border-spacing: 0;
        min-width: 500px;
        max-width: 500px;
    }
</style>
<img src="page/vaccine/covidstat3.jpg" alt="bg" style="width: 1200px;">
                <div class="showdate">
                    <?php 
                        echo DateThai(date("Y-m-d"));;
                    ?>
                </div>

                                            <div class="total-all h5 mb-0 font-weight-bold text-gray-800">
                                                <?php  
                                                    $sql = "SELECT * FROM temp_stat";
                                                    // echo $sqlvaccinecount;
                                                    $query = mysqli_query($con,$sql);
                                                    while($row = mysqli_fetch_assoc($query)){
                                                    echo number_format($row["vaccinedoseall"], 0, '', ','); ?>    
                                                </div>
                                                <div class="total-all2 progress mb-2 mt-3">
                                                    <div class="progress-bar " role="progressbar" style="background:linear-gradient(to right, #66ccff 0%, #0066ff 100%);width: <?php echo number_format((float)(($row["target_current"]*100)/297474), 2, '.', '')."%";?>"
                                                        aria-valuenow="<?php echo number_format((float)(($row["target_current"]*100)/297474), 2, '.', ',');?>" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <h4 class="total-all3 small font-weight-bold">กลุ่มเป้าหมาย <?php echo number_format($row["target_current"], 0, '', ','); ?> / 297,474 คน
                                                </h4><span class="total-all4"><?php echo number_format((float)(($row["target_current"]*100)/297474), 2, '.', ',')."%";?></span>
                                                <?php }?>
            <b><table class="table-stat">
                <thead class="">
                    <tr>
                        <th rowspan="2" class="text-center" style="width: 140px;">สถานที่ฉีดวัคซีน</th>
                        <th rowspan="2" class="text-center" style="width: 120px;">ประชากรกลุ่มเป้าหมาย<br>(ร้อยละ70)</th>
                        <th rowspan="2" class="text-center" style="width: 80px;">จำนวนคนที่ฉีดได้ต่อวัน</th>
                        <th rowspan="2" class="text-center" style="width: 80px;">จำนวนการจองวัคซีน</th>
                        <th class="text-center" colspan="6" style="width: 120px;">จำนวนการฉีดวัคซีน</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="width: 90px;">เข็มที่ 1</th>
                        <th class="text-center" style="width: 90px;">ร้อยละ</th>
                        <th class="text-center" style="width: 90px;">เข็มที่ 2</th>
                        <th class="text-center" style="width: 90px;">ร้อยละ</th>
                        <th class="text-center" style="width: 90px;">เข็มที่ 3</th>
                        <th class="text-center" style="width: 90px;">ร้อยละ</th>
                    </tr>
                </thead>
                <tbody class="text-end align-top" style="height:535px; ">
                    

                <?php
                    $sql3 = "(SELECT hospital_name,goal,spray_day,total,
                    plan_1,plan_1/goal*100 as per1,
                    plan_2,plan_2/goal*100 as per2,
                    plan_3,plan_3/goal*100 as per3 
                    FROM vac_proc WHERE proc_status='1' AND proc_date=curdate() ORDER BY priority ASC )
                    union all
                    (SELECT 'รวม',SUM(goal),SUM(spray_day),SUM(total),
                    SUM(plan_1),(SUM(plan_1)/SUM(goal)*100),
                    SUM(plan_2),(SUM(plan_2)/SUM(goal)*100),
                    SUM(plan_3),(SUM(plan_3)/SUM(goal)*100) 
                    FROM vac_proc WHERE proc_status='1' AND proc_date=curdate() ORDER BY priority ASC )";
                    $query3 = mysqli_query($con,$sql3);
                    while($row = mysqli_fetch_assoc($query3)){ ?>
                    <tr class="text-center" style="font-size: 21px;">
                        <td class="text-start" style="font-size: 19px;" ><?php 
                        if($row['hospital_name']=="โรงพยาบาลพัทลุง"){
                            echo "รพ.พัทลุง";
                        }if($row['hospital_name']=="โรงพยาบาลกงหรา"){
                            echo "รพ.กงหรา<br><span style='font-size: 15px;'>(หอประชุมอ.กงหรา)</span>";
                        }if($row['hospital_name']=="โรงพยาบาลเขาชัยสน"){
                            echo "รพ.เขาชัยสน";
                        }if($row['hospital_name']=="โรงพยาบาลตะโหมด"){
                            echo "รพ.ตะโหมด";
                        }if($row['hospital_name']=="โรงพยาบาลควนขนุน"){
                            echo "รพ.ควนขนุน<br><span style='font-size: 15px;'>(หอประชุมเทศบาลควนขนุน)</span>";
                        }if($row['hospital_name']=="โรงพยาบาลปากพะยูน"){
                            echo "รพ.ปากพะยูน";
                        }if($row['hospital_name']=="โรงพยาบาลศรีบรรพต"){
                            echo "รพ.ศรีบรรพต";
                        }if($row['hospital_name']=="โรงพยาบาลป่าบอน"){
                            echo "รพ.ป่าบอน";
                        }if($row['hospital_name']=="โรงพยาบาลบางแก้ว"){
                            echo "รพ.บางแก้ว";
                        }if($row['hospital_name']=="โรงพยาบาลป่าพะยอม"){
                            echo "รพ.ป่าพะยอม<br><span style='font-size: 15px;'>(อาคารศูนย์กิจกรรมนิสิตม.ทักษิณฯ)</span>";
                        }if($row['hospital_name']=="โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)"){
                            echo "รพ.ศรีนครินทร์";
                        }if($row['hospital_name']=="รวม"){
                            echo "<center>รวม</center>";
                        }
                        ?></td>
                        <td><?php echo number_format((float)($row['goal']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['spray_day']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['total']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['plan_1']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['per1']), 2, '.', ',')."%";?></td>
                        <td><?php echo number_format((float)($row['plan_2']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['per2']), 2, '.', ',')."%";?></td>
                        <td><?php echo number_format((float)($row['plan_3']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['per3']), 2, '.', ',')."%";?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfooter>

                </tfooter>
            </table></b>
 <!-- ตารางที่ 2 -->
            <b><table class="table-stat2">
                <thead class="">
                    <tr>
                        <th rowspan="2" class="text-center" style="width: 168px;">เป้าหมาย</th>
                        <th class="text-center" colspan="2" style="width: 120px;">เข็ม1</th>
                        <th class="text-center" colspan="2" style="width: 120px;">เข็ม2</th>
                        <th class="text-center" colspan="2" style="width: 120px;">เข็ม3</th>
                    </tr>
                    <tr>
                        <th class="text-center"style="width: 85px;">เข็มที่ 1</th>
                        <th class="text-center"style="width: 85px;">ร้อยละ</th>
                        <th class="text-center"style="width: 85px;">เข็มที่ 2</th>
                        <th class="text-center"style="width: 85px;">ร้อยละ</th>
                        <th class="text-center"style="width: 85px;">เข็มที่ 3</th>
                        <th class="text-center"style="width: 85px;">ร้อยละ</th>
                    </tr>
                </thead>
                <tbody class="text-end align-top" style="height:300px; ">
                    

                <?php
                    $sql4 = "select * from vac_book_config";
                    $query4 = mysqli_query($con,$sql4);
                    while($row = mysqli_fetch_assoc($query4)){ ?>
                    <tr class="text-center" style="font-size: 19px;">
                        <td class="text-start" style="font-size: 16px;" ><?php echo $row['group_name'];?></td>
                        <td><?php echo number_format((float)($row['dose1']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['dose1_percent']), 2, '.', ',')."%";?></td>
                        <td><?php echo number_format((float)($row['dose2']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['dose2_percent']), 2, '.', ',')."%";?></td>
                        <td><?php echo number_format((float)($row['dose3']), 0, '', ',');?></td>
                        <td><?php echo number_format((float)($row['dose3_percent']), 2, '.', ',')."%";?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfooter>

                </tfooter>
            </table></b>

        <div class="chart-vaccine">
            <?php 
                include 'vacnum.php' ;
            ?>
        </div>