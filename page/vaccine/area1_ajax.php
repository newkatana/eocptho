<style>
		#progressbar {
		text-align: center;
		background-color: #f2f2f2;
		padding: 0px;
		position: relative;
		}

		/* #progressbar>div {
			background-color: #ffe680;
			height: 20px;
		} */

		.progress-label {
			font-size: .8em;
			position: absolute;
			margin: 0;
			left: 0;
			right: 0;
			text-align: center;
			/* transform: translateY(-50%); */
			/* top: 50%; */
		}
		h1,h2,h3,h4,h5,h6 {
			font-family: 'Sarabun', sans-serif;
		};
		
	</style>
<?php  
 //load_data.php  
//  $connect = mysqli_connect("localhost", "root", "", "zzz");
include '../../../dbcon.php';  
 $output = '';  
 if(isset($_POST["brand_id"]))  
 {  
      if($_POST["brand_id"] != '')  
      {  
           $sql = "SELECT t1.*,t2.targettambon
           FROM 
           (SELECT ampurname,ampurcodefull,tamboncodefull,tambonname,
           count(*) as dose1
           FROM eoc_area_cover1
           WHERE ampurcodefull = '".$_POST["brand_id"]."'
           GROUP BY tamboncodefull
            ORDER BY tamboncodefull) t1
            INNER JOIN
            (SELECT ampurcodefull,tamboncodefull,count(*) as targettambon
                    FROM eoc_area_hdc_target
                    GROUP BY tamboncodefull) t2
            ON t1.tamboncodefull = t2.tamboncodefull";  
      }  
      else  
      {  
            $sql = "SELECT t1.*,t2.targettambon
            FROM 
            (SELECT ampurname,ampurcodefull,tamboncodefull,tambonname,
            count(*) as dose1
            FROM eoc_area_cover1
            GROUP BY tamboncodefull
            ORDER BY tamboncodefull) t1
            INNER JOIN
            (SELECT ampurcodefull,tamboncodefull,count(*) as targettambon
                    FROM eoc_area_hdc_target
                    GROUP BY tamboncodefull) t2
            ON t1.tamboncodefull = t2.tamboncodefull";  
      }  
      $result = mysqli_query($con, $sql); 
            $output .= '<div class="container-fluid"><table class="table table-sm  rounded table-bordered">'; 
            $output .= '<thead class="text-center" style="background-color:#f2f2f2;"><th>รหัส</th><th>ตำบล</th><th>เป้าหมาย</th><th>เข็ม 1</th><th>ร้อยละ</th></thead>'; 
            $output .= '<tbody>'; 
      while($row = mysqli_fetch_array($result))  
      {   
            $output .= '<tr class="text-center">';            
            $output .= '<td>'.$row['tamboncodefull'].'</td>'; 
            $output .= '<td class="text-left">'.$row["tambonname"].'</td>';
            $output .= '<td>'.number_format($row['targettambon'],0,'.',',').'</td>';
            $output .= '<td>'.number_format($row['dose1'],0,'.',',').'</td>'; 
            $output .= '<td>'.number_format($row['dose1']/$row['targettambon']*100,2,'.',',').'</td>';  
            $output .= '</tr>';  
      }  
            $output .= '</tbody></table></div>'; 
      echo $output;  
 }  

 ?> 