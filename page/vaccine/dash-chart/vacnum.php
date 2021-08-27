<?php
require_once 'db.php';

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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- javascript สำหรับเขียนคำสั่งเรียกใช้งาน apexcharts library -->
<script>

var options = {
          series: [{
          name: 'วัคซีนเข็มที่ 1',
          data: <?=json_encode($value);?>
        },{
          name: 'วัคซีนเข็มที่ 2',
          data: <?=json_encode($value2);?>
        },{
          name: 'วัคซีนเข็มที่ 3',
          data: <?=json_encode($value3);?>
        }],
          chart: {
          width: '100%',
          height: 380,
          type: 'area'
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        xaxis: {
          type: 'datetime',
          categories: <?=json_encode($title);?>
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