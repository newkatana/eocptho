<?php
require_once 'db.php';

// ดึงวันที่ปัจจุบัน
$datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
$query_time = mysqli_query($con,$datadate);
$date_current;
while($row = mysqli_fetch_assoc($query_time)){
  $date_current=DateThai(date($row['date']));
}

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
            // $ref_hospital_name[] = $row['ref_hospital_name'];
            $ref_hospital_name[] = str_replace("โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)","โรงพยาบาลศรีนครินทร์",$row['ref_hospital_name']);
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

<div class="container-extend mb-3 pb-4">
<table class="table table-sm table-bordered">
<thead class="text-center" style="background-color:#f2f2f2;">
  <tr>
    <th rowspan="2">โรงพยาบาล</th>
    <th rowspan="2">เป้าหมาย(คน)</th>
    <th rowspan="2">อัตราการฉีด<br>(โดส/วัน)</th>
    <th rowspan="2">ยอดจอง<br>(คิว)</th>
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
    $sql_table = "SELECT eoc_target.ref_hospital_name,eoc_target.hospital_code,SUM(eoc_target.target) as sTarget,eoc_target.rate,eoc_ratetarget.queue,eoc_ratetarget.slot,
                SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal
                FROM eoc_target
                INNER JOIN eoc_vaccine_group
                ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code
                INNER JOIN eoc_ratetarget
                ON eoc_vaccine_group.hospital_code = eoc_ratetarget.hospital_code
                group by eoc_vaccine_group.ref_hospital_name ORDER BY hospital_code";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
          <td><?php 
                    if($row['ref_hospital_name']=='โรงพยาบาลศรีนครินทร์(ปัญญานันทภิขุ)'){
                        echo 'โรงพยาบาลศรีนครินทร์';
                    }else echo $row['ref_hospital_name']; ?></td>
          <td class="text-right"><?php echo number_format($row['sTarget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['rate'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['queue']+$row['slot'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose1']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose2']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sDose3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['sDose3']/$row['sTarget']); ?></td>
          <td class="text-right"><?php echo number_format($row['sTotal'], 0, '.', ','); ?></td>
          </tr>
        <?php }; ?>
    <tbody>
    <tfooter>
    <?php 
    $sql_table = "SELECT 
    sum(queue) as squeue,sum(rate) as srate,sum(xd) as starget,sum(slot) as sslot,sum(sDose1) as x1,sum(sDose2) as x2,sum(sDose3) as x3,sum(sTotal) as xtotal
    FROM 
        (SELECT * FROM eoc_ratetarget) t1
    INNER JOIN
        (SELECT hospital_code,SUM(Dose1) as sDose1,SUM(Dose2) as sDose2,SUM(Dose3) as sDose3,SUM(Total) as sTotal FROM eoc_vaccine_group
    group by eoc_vaccine_group.hospital_code) t2 
    ON t1.hospital_code = t2.hospital_code 
    INNER JOIN
        (SELECT sum(eoc_target.target) as xd,hospital_code FROM eoc_target group by hospital_code) t3
    ON t1.hospital_code = t3.hospital_code
    ";
    $result_table = mysqli_query($con, $sql_table);
    while($row = mysqli_fetch_assoc($result_table)) { ?>
        <tr class="">
        <td class="text-center"><?php echo "รวม"; ?></td>
          <td class="text-right"><?php echo number_format($row['starget'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['srate'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['squeue']+$row['sslot'], 0, '.', ','); ?></td>
          <td class="text-right"><?php echo number_format($row['x1'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x1']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['x2'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x2']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['x3'], 0, '.', ','); ?></td>
          <td class="text-right"><?php percentbar2($row['x3']/$row['starget']); ?></td>
          <td class="text-right"><?php echo number_format($row['xtotal'], 0, '.', ','); ?></td>
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
          return val;
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
          <?php
              $dt=$pieces = explode("เวลา", $date_current);
          ?>
          // text: 'ร้อยละของผู้ได้รับวัคซีนทั้งหมดเทียบเป้าหมาย แยกรายโรงพยาบาล แยกเข็ม',
          <?php echo "text: ['ร้อยละของผู้ได้รับวัคซีนทั้งหมดเทียบเป้าหมาย','แยกรายอำเภอ จังหวัดพัทลุง ข้อมูล ณ วันที่ {$dt[0]}'],"; ?>
          align: 'center',
          style: {
            fontSize:  '20px',
            fontWeight:  'bold',
            fontFamily:  undefined,
            color:  'blue'
          },
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
              return val;
            }
          }
        }
        };

        var hos_count_chart = new ApexCharts(document.querySelector("#hos_count_chart"), options);
        hos_count_chart.render();


</script>