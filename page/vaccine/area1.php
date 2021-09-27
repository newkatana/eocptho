<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h3 class="text-white">ข้อมูลความครอบคลุมประชากรเข็ม1(1,3) รายพื้นที่ จังหวัดพัทลุง</h3>
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
    <div class="col-7">
            <?php include 'page/vaccine/map/mapping.php'  ?>
    </div>
    <div class="col-5">
        <h6 class="text-primary">hdc : typearea 1,3 & คนไทย & อายุ >=18</h6>
    <table class="table table-sm  rounded table-bordered">
            <thead class="text-center" style="background-color:#f2f2f2;">
                <th>อำเภอ</th>
                <th>เป้าหมาย</th>
                <th>เข็ม 1</th>
                <th>ร้อยละ</th>
            </thead>
                    <tbody>
        <?php   $sql = "SELECT t1.*,t2.targetall FROM 
                            (SELECT ampurname,ampurcodefull,
                            count(*) as dose1
                            FROM eoc_area_cover1
                            GROUP BY ampurcodefull 
                            ORDER BY ampurcodefull) t1
                                INNER JOIN
                            (SELECT LEFT(vhid,4) as ampurcodefull,count(*) as targetall
                            FROM group_person WHERE age_y >= 18 
                            GROUP BY ampurcodefull) t2
                            ON t1.ampurcodefull = t2.ampurcodefull"; 
                $query = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($query)){; 
                ?>
                <tr class="text-center">
                        <td class="text-left"><?php echo $row['ampurname']; ?></td>
                        <td><?php echo number_format($row['targetall'],0,'.',','); ?></td>
                        <td><?php echo number_format($row['dose1'],0,'.',','); ?></td>
                        <td><?php percentbar3($row['dose1']/$row['targetall']); ?></td>
                    </tr>
                    <?php   };?>
                </tbody>
                <tfooter>
                <?php $sql_group_b = "SELECT SUM(t1.dose1) as dose1 ,SUM(t2.targetall) as targetall FROM 
                            (SELECT ampurname,ampurcodefull,
                            count(*) as dose1
                            FROM eoc_area_cover1
                            GROUP BY ampurcodefull 
                            ORDER BY ampurcodefull) t1
                                INNER JOIN
                            (SELECT LEFT(vhid,4) as ampurcodefull,count(*) as targetall
                            FROM group_person WHERE age_y >= 18 
                            GROUP BY ampurcodefull) t2
                            ON t1.ampurcodefull = t2.ampurcodefull";
                    $query_group_b = mysqli_query($con,$sql_group_b);
                    while($row = mysqli_fetch_assoc($query_group_b)){; 
                    ?>
                    <tr class="text-center">
                            <td class="text-center"><?php echo 'รวม'; ?></td>
                            <td><?php echo number_format($row['targetall'],0,'.',','); ?></td>
                            <td><?php echo number_format($row['dose1'],0,'.',','); ?></td>
                            <td><?php percentbar3($row['dose1']/$row['targetall']); ?></td>
                        </tr>
                        <?php   };?>
                </tfooter>
            </table>
    
<br>

<?php   
 //load_data_select.php  
//  $connect = mysqli_connect("localhost", "root", "", "zzz");  
 function fill_brand($con)  
 {  
      $output = '';  
      $sql = "SELECT ampurcodefull,ampurname,tamboncodefull
      FROM eoc_area_hdc_target
      GROUP BY ampurcodefull";  
      $result = mysqli_query($con, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '<option value="'.$row["ampurcodefull"].'">'.$row["ampurname"].'</option>';  
      }  
      return $output;  
 }  
 function fill_product($con)  
 {  
      $output = '';  
      $sql = "SELECT * FROM product";  
      $result = mysqli_query($con, $sql);  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '<div class="col-md-3">';  
           $output .= '<div style="border:1px solid #ccc; padding:20px; margin-bottom:20px;">'.$row["product_name"].'';  
           $output .=     '</div>';  
           $output .=     '</div>';  
      }  
      return $output;  
 }  
 ?>    
    <h6 class="text-primary">ดูข้อมูลรายตำบล</h6>
    <h6> อำเภอ : 
          <select name="brand" id="brand">  
              <option value="" selected disabled>--กรุณาเลือกอำเภอ--</option>  
              <?php echo fill_brand($con); ?>  
          </select>  
          <br /><br />  
          <div class="row" id="show_product">  
              <?php //echo fill_product($con);?>  
          </div>  
    </h6> 

</div>
</div>
<script>  
 $(document).ready(function(){  
      $('#brand').change(function(){  
           var brand_id = $(this).val();  
           $.ajax({  
                url:"page/vaccine/area1_ajax.php",  
                method:"POST",  
                data:{brand_id:brand_id},  
                success:function(data){  
                     $('#show_product').html(data);  
                }  
           });  
      });  
 });  
 </script> 
