                            <h6 class="m-0 font-weight-bold text-primary">การดำเนินการให้วัคซีน COVID-19 สำหรับผู้สูงอายุ/ผู้ป่วยโรคเรื้อรัง 7 กลุ่มโรค/หญิงตั้งครรภ์ จังหวัดพัทลุง<br>ความครอบคลุมการฉีดวัคซีนโควิด 19 ประชากรในเขตรับผิดชอบ (1,3)</h6>
                        <div class="card-body">

                                <!-- Content Row -->
                    <?php 
                        $sql="SELECT * FROM mis.users WHERE status='2'";
                        $rs_amphur=mysqli_query($con,$sql);
                        while($array=mysqli_fetch_array($rs_amphur)){
                    ?>
                    <!-- ############################################################################# -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-12">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-12">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $array['hosname']; ?></h6>
                                </div>
                                <div class="card-body">

                                <!-- ################################################################################################## -->
                                <div class="scrollme">    
                            <div class="table-responsive">
                            <table id="corporate" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr class="">
                                    <!-- <th scope="col">#</th> -->
                                    <th scope="col"  rowspan="2" valign="middle"><center>ลำดับที่</center></th>
                                    <th scope="col" rowspan="2" valign="middle"><center>หน่วยบริการ</center></th>
                                    <th scope="col" rowspan="2" class="table-primary" valign="middle"><center>เป้าหมาย</center></th>
                                    <th scope="col" colspan="2" class="table-primary"><center>เข็ม 1 [60 ปีขึ้นไป]</center></th>
                                    <th scope="col" colspan="2" class="table-primary"><center>เข็ม 2 [60 ปีขึ้นไป]</center></th>

                                    <th scope="col" rowspan="2" class="table-danger" valign="middle"><center>เป้าหมาย</center></th>
                                    <th scope="col" colspan="2" class="table-danger"><center>เข็ม 1 ผู้ป่วยโรคเรื้อรัง 7 กลุ่มโรค</center></th>
                                    <th scope="col" colspan="2" class="table-danger"><center>เข็ม 2 ผู้ป่วยโรคเรื้อรัง 7 กลุ่มโรค</center></th>

                                    <th scope="col" rowspan="2" class="table-success" valign="middle"><center>เป้าหมาย</center></th>
                                    <th scope="col" colspan="2" class="table-success"><center>เข็ม 1 หญิงตั้งครรภ์</center></th>
                                    <th scope="col" colspan="2" class="table-success"><center>เข็ม 2 หญิงตั้งครรภ์</center></th>
                                </tr>
                                <tr class="">
                                    <th scope="col" rowspan="2" class="table-primary" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-primary" ><center>คิดเป็นเปอร์เซ็น</center></th>
                                    <th scope="col" rowspan="2" class="table-primary" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-primary" ><center>คิดเป็นเปอร์เซ็น</center></th>

                                    <th scope="col" rowspan="2" class="table-danger" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-danger" ><center>คิดเป็นเปอร์เซ็น</center></th>
                                    <th scope="col" rowspan="2" class="table-danger" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-danger" ><center>คิดเป็นเปอร์เซ็น</center></th>

                                    <th scope="col" rowspan="2" class="table-success" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-success" ><center>คิดเป็นเปอร์เซ็น</center></th>
                                    <th scope="col" rowspan="2" class="table-success" valign="middle"><center>จำนวนการฉีดวัคซีน</center></th>
                                    <th scope="col" rowspan="2" class="table-success" ><center>คิดเป็นเปอร์เซ็น</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                        $sql="SELECT t1.vhid,t1.discode,t1.hospcode,sum(t1.elderly) as elderly ,sum(t1.elderly_plan_1) as elderly_plan_1,sum(t1.elderly_plan_1_percent) as elderly_plan_1_percent,sum(t1.elderly_plan_2) as elderly_plan_2,sum(t1.elderly_plan_2_percent) as elderly_plan_2_percent
                                        ,sum(t1.7disease) as 7disease ,sum(t1.7disease_plan_1) as 7disease_plan_1,sum(t1.7disease_plan_1_percent) as 7disease_plan_1_percent,sum(t1.7disease_plan_2) as 7disease_plan_2,sum(t1.7disease_plan_2_percent) as 7disease_plan_2_percent
                                        ,sum(t1.prenatal) as prenatal,sum(t1.prenatal_plan_1) as prenatal_plan_1,sum(t1.prenatal_plan_1_percent) as prenatal_plan_1_percent,sum(t1.prenatal_plan_2) as prenatal_plan_2,sum(prenatal_plan_2_percent) as prenatal_plan_2_percent
                                        ,t2.hosname as hospname FROM _TEMP_VAC_CORPORATE t1 LEFT JOIN hdc.chospital t2 on t1.hospcode=t2.hoscode where t1.discode='{$array['discode']}' group by hospcode ";
                                        $result=mysqli_query($con,$sql);
                                        $i=1;
                                        $sum_elderly_goal_1=0;
                                        $sum_elderly_plan_1=0;
                                        $sum_elderly_goal_2=0;
                                        $sum_elderly_plan_2=0;

                                        $sum_7disease_goal_1=0;
                                        $sum_7disease_plan_1=0;
                                        $sum_7disease_goal_2=0;
                                        $sum_7disease_plan_2=0;

                                        $sum_prenatal_goal_1=0;
                                        $sum_prenatal_plan_1=0;
                                        $sum_prenatal_goal_2=0;
                                        $sum_prenatal_plan_2=0;

                                        while($array=mysqli_fetch_array($result)){
                                            $sum_elderly_goal_1+=$array['elderly'];
                                            $sum_elderly_plan_1+=$array['elderly_plan_1'];
                                            $sum_elderly_goal_2+=$array['elderly'];
                                            $sum_elderly_plan_2+=$array['elderly_plan_2'];

                                            $sum_7disease_goal_1+=$array['7disease'];
                                            $sum_7disease_plan_1+=$array['7disease_plan_1'];
                                            $sum_7disease_goal_2+=$array['7disease'];
                                            $sum_7disease_plan_2+=$array['7disease_plan_2'];

                                            $sum_prenatal_goal_1+=$array['prenatal'];
                                            $sum_prenatal_plan_1+=$array['prenatal_plan_1'];
                                            $sum_prenatal_goal_2+=$array['prenatal'];
                                            $sum_prenatal_plan_2+=$array['prenatal_plan_2'];
                                 ?>
                        
                                            <tr>
                                                <th scope="row"><?php echo $i; ?></th>
                                                <td><?php echo $array['hospname']; ?></td>
                                                <td class="table-primary"><?php echo number_format($array['elderly']); ?></td>
                                                <td class="table-primary"><?php echo number_format($array['elderly_plan_1']); ?></td>
                                                <td class="table-primary"><?php echo $array['elderly_plan_1_percent']."%"; ?></td>
                                                <td class="table-primary"><?php echo number_format($array['elderly_plan_2']); ?></td>
                                                <td class="table-primary"><?php echo $array['elderly_plan_2_percent']."%"; ?></td>

                                                <td class="table-danger"><?php echo number_format($array['7disease']); ?></td>
                                                <td class="table-danger"><?php echo number_format($array['7disease_plan_1']); ?></td>
                                                <td class="table-danger"><?php echo $array['7disease_plan_1_percent']."%"; ?></td>
                                                <td class="table-danger"><?php echo number_format($array['7disease_plan_2']); ?></td>
                                                <td class="table-danger"><?php echo $array['7disease_plan_2_percent']."%"; ?></td>

                                                <td class="table-success"><?php echo number_format($array['prenatal']); ?></td>
                                                <td class="table-success"><?php echo number_format($array['prenatal_plan_1']); ?></td>
                                                <td class="table-success"><?php echo $array['prenatal_plan_1_percent']."%"; ?></td>
                                                <td class="table-success"><?php echo number_format($array['prenatal_plan_2']); ?></td>
                                                <td class="table-success"><?php echo $array['prenatal_plan_2_percent']."%"; ?></td>

                                            </tr>
                                <?php
                                            $i++;
                                        }
                                ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <!-- <th scope="col">#</th> -->
                                    <th scope="col" rowspan="2" valign="middle">ภาพรวมอำเภอ</th>
                                    <th scope="col"></th>
                                    <th class="table-primary" scope="col"><?php echo number_format($sum_elderly_goal_1); ?></th>
                                    <th class="table-primary" scope="col"><?php echo number_format($sum_elderly_plan_1); ?></th></th>
                                    <th class="table-primary" scope="col"><?php echo number_format(($sum_elderly_plan_1*100)/$sum_elderly_goal_1, 2, '.', '')."%"; ?></th>
                                    <th class="table-primary" scope="col"><?php echo number_format($sum_elderly_plan_2); ?></th></th>
                                    <th class="table-primary" scope="col"><?php echo number_format(($sum_elderly_plan_2*100)/$sum_elderly_goal_2, 2, '.', '')."%"; ?></th>
                                    
                                    <th class="table-danger"  scope="col"><?php echo number_format($sum_7disease_goal_1); ?></th>
                                    <th class="table-danger" scope="col"><?php echo number_format($sum_7disease_plan_1); ?></th></th>
                                    <th class="table-danger" scope="col"><?php echo number_format(($sum_7disease_plan_1*100)/$sum_7disease_goal_1, 2, '.', '')."%"; ?></th>
                                    <th class="table-danger" scope="col"><?php echo number_format($sum_7disease_plan_2); ?></th></th>
                                    <th class="table-danger" scope="col"><?php echo number_format(($sum_7disease_plan_2*100)/$sum_7disease_goal_2, 2, '.', '')."%"; ?></th>

                                    <th class="table-success"  scope="col"><?php echo number_format($sum_prenatal_goal_1); ?></th>
                                    <th class="table-success" scope="col"><?php echo number_format($sum_prenatal_plan_1); ?></th></th>
                                    <th class="table-success" scope="col"><?php echo number_format(($sum_prenatal_plan_1*100)/$sum_prenatal_goal_1, 2, '.', '')."%"; ?></th>
                                    <th class="table-success" scope="col"><?php echo number_format($sum_prenatal_plan_2); ?></th></th>
                                    <th class="table-success" scope="col"><?php echo number_format(($sum_prenatal_plan_2*100)/$sum_prenatal_goal_2, 2, '.', '')."%"; ?></th>

                                </tr>
                            </thead>
                        </table>
                        </div>
                            </div>


                        </div>

                            </div>
                                    </div>
                            <!-- ################################################################################################## -->

                                </div>

                                <?php
                        }
                    ?>
