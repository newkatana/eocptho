<?php
require_once 'db.php';
$sql = "SELECT * FROM temp_stat";
// echo $sqlvaccinecount;
$query = mysqli_query($con,$sql);
while($row = mysqli_fetch_assoc($query)){
    $sv1count = $row["sv1count"];
    $sv2count = $row["sv2count"];
    $az1count = $row["az1count"];
    $az2count = $row["az2count"];
    $az3count = $row["az3count"];
    $pf1count = $row["pf1count"];
    $pf2count = $row["pf2count"];
    $pf3count = $row["pf3count"];}
$sql1 = "SELECT * FROM temp_vacnum1"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result = mysqli_query($con, $sql1);
    $title = [];
    $value = [];
    if (mysqli_num_rows($result) > 0) {
        
        while($row1 = mysqli_fetch_assoc($result)) {
            $title[] = $row1['immunization_date'];
            $value[] = $row1['CumulativeSum'];
            // print_r($title);
        }
    }

$sql2 = "SELECT * FROM temp_vacnum2"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result2 = mysqli_query($con, $sql2);
    $title2 = [];
    $value2 = [];
    if (mysqli_num_rows($result2) > 0) {
        
        while($row2 = mysqli_fetch_assoc($result2)) {
            $title2[] = $row2['immunization_date'];
            $value2[] = $row2['CumulativeSum'];
            // print_r($title);
        }
    }
  $sql3 = "SELECT * FROM temp_vacnum3"; //คำสั่ง เลือกข้อมูลจากตาราง report
  
      $result3 = mysqli_query($con, $sql3);
      $title3 = [];
      $value3 = [];
      if (mysqli_num_rows($result3) > 0) {
          
          while($row3 = mysqli_fetch_assoc($result3)) {
              $title3[] = $row3['immunization_date'];
              $value3[] = $row3['CumulativeSum'];
              // print_r($title);
          }
      }
?>
  <style>
		#chartvac {
		  /* max-width: 600px; */
		  margin: auto;
      
		}  

		/* .apexcharts-menu-item.exportSVG {
		  display: none;
		} */

		/* .apexcharts-menu-item.exportCSV {
		  display: none;
		} */
  </style>

<!-- แสดงข้อมูล Chart -->
<div id="chartvac"></div>
    <!-- <p class="text-center"><b>วัคซีนเข็มที่ 1️⃣ : </b><?php /*$svaz1 = $sv1count+$az1count+$pf1count ;echo  number_format($svaz1, 0, '', ',')." Dose";?></p>
    <p class="text-center"><b>วัคซีนเข็มที่ 2️⃣ : </b><?php $svaz2 = $sv2count+$az2count+$pf2count ;echo  number_format($svaz2, 0, '', ',')." Dose"; ?></p>
    <p class="text-center pb-0 mb-0"><b>วัคซีนเข็มที่ 3️⃣ : </b><?php $svaz3 = $az3count+$pf3count ;echo  number_format($svaz3, 0, '', ',')." Dose"; */?></p> -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- javascript สำหรับเขียนคำสั่งเรียกใช้งาน apexcharts library -->
<script>

var options = {
          series: [{
          name: 'วัคซีนเข็มที่ 1',
          data: <?=json_encode($value);?>
          },{
            name: 'วัคซีนเข็มที่ 2',
            data: <?=json_encode($value2);?>,
            
          },{
            name: 'วัคซีนเข็มที่ 3',
            data: <?=json_encode($value3);?>,
          }],
          dataLabels: {
            enabled: false,
          },
          stroke: {
            curve: 'smooth'
          },
          xaxis: {
            type: 'datetime',
            hideOverlappingLabels: false,
            categories: <?=json_encode($title);?>,
            labels:{
              style:{
                fontSize: '16px',
              }
            }
          },
          chart :{
            toolbar: {
            show:false
            },
            type: 'area',
            width: '100%',
            height: 500,
          },
          
          tooltip: {
            x: {
              format: 'dd/MM/yyyy'
            },
          },

        };

        var chartvac = new ApexCharts(document.querySelector("#chartvac"), options);
        chartvac.render();
</script>