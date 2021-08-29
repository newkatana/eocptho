<?php
require_once 'db.php';

$sql = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(target) as sTarget,
SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
FROM eoc_target
INNER JOIN eoc_vaccine_group
ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
group by ref_hospital_name ORDER BY hospital_code"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result = mysqli_query($con, $sql);
    $ref_hospital_name = [];
    $target = [];
    $dose1 = [];
    $dose2 = [];
    $dose3 = [];
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $ref_hospital_name[] = $row['ref_hospital_name'];
            $target[] = $row['sTarget'];
            $dose1[] = number_format($row['sDose1']/$row['sTarget']*100, 2, '.', ',');
            $dose2[] = number_format($row['sDose2']/$row['sTarget']*100, 2, '.', ',');
            $dose3[] = number_format($row['sDose3']/$row['sTarget']*100, 2, '.', ',');
            // print_r($title);
        }
    };

?>
  <style>
		#hos_count_chart {
		  /* max-width: 600px; */
		  margin: auto;
		}

		/* .apexcharts-menu-item.exportSVG {
		  display: none;
		}

		.apexcharts-menu-item.exportCSV {
		  display: none;
		} */
  </style>

<!-- แสดงข้อมูล Chart -->
<div id="hos_count_chart">
</div>
<div class=" container-fluid">
<table class="table table-sm table-bordered">
<thead class="text-center" style="background-color:#f2f2f2;">
  <tr>
    <th rowspan="2">โรงพยาบาล</th>
    <th rowspan="2">เป้าหมาย(คน)</th>
    <th colspan="2">เข็ม 1 (โดส)</th>
    <th colspan="2">เข็ม 2 (โดส)</th>
    <th colspan="2">เข็ม 3 (โดส)</th>
    <th rowspan="2">รวม 3 เข็ม <br> (โดส)</th>
  </tr>
  <tr>
    <th>จำนวน</th>
    <th>ร้อยละ</th>
    <th>จำนวน</th>
    <th>ร้อยละ</th>
    <th>จำนวน</th>
    <th>ร้อยละ</th>
  </tr>
</thead>
  <tbody>
    <?php 
    $sql_table = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(target) as sTarget,
                  SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                  FROM eoc_target
                  INNER JOIN eoc_vaccine_group
                  ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
                  group by ref_hospital_name ORDER BY hospital_code";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
          <td><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
          <td class="text-right"><?php echo number_format($row['sTarget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose1']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose2']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose3']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sTotal'], 0, '.', ','); ?></td>
          </tr>
        <?php }; ?>
    <tbody>
    <tfooter>
    <?php 
    $sql_table = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(target) as sTarget,
                  SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                  FROM eoc_target
                  INNER JOIN eoc_vaccine_group
                  ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
          <td class="text-center"><?php echo "รวม"; ?></td>
          <td class="text-right"><?php echo number_format($row['sTarget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose1']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose2']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar($row['sDose3']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sTotal'], 0, '.', ','); ?></td>
          </tr>
        <?php }; ?>   
    </tfooter>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- javascript สำหรับเขียนคำสั่งเรียกใช้งาน apexcharts library -->
<script>
        var options = {
          series: [{
          name: 'วัคซีนเข็ม1',
          data: <?=json_encode($dose1);?>
        }, {
          name: 'วัคซีนเข็ม2',
          data: <?=json_encode($dose2);?>
        }, {
          name: 'วัคซีนเข็ม3',
          data: <?=json_encode($dose3);?>
        }],
          chart: {
          type: 'bar',
          height: 500
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '70%',
            endingShape: 'rounded',
            dataLabels: {
            position: "top" // top, center, bottom
          }
          },
        },
        dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val + "%";
        },
        offsetY: -20,
        style: {
          fontSize: "12px",
          colors: ["#304758"]
        }
      },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        title: {
          text: 'ร้อยละของผู้ได้รับวัคซีนทั้งหมดเทียบเป้าหมาย แยกรายโรงพยาบาล แยกเข็ม',
          align: 'center',
          // offsetX: 110
        },
        xaxis: {
          categories: <?=json_encode($ref_hospital_name);?>,
          labels: {
            hideOverlappingLabels: false,
            rotate: -45,
            rotateAlways: true,
            trim: false,
            show: true,
          }
        },
        yaxis: {
          title: {
            text: 'ร้อยละ'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " %"
            }
          }
        }
        };

        var hos_count_chart = new ApexCharts(document.querySelector("#hos_count_chart"), options);
        hos_count_chart.render();


</script>