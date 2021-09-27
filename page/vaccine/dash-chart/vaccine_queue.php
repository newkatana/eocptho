
<?php
require_once 'db.php';

$sql1 = "SELECT t2.hospital_code,t2.queue_number,SUM(CASE WHEN t1.cid IS NULL THEN '0' ELSE '1' END) as stotal FROM 
(SELECT cid FROM eoc_person_cid_queue_tmp) t1
RIGHT JOIN
(SELECT cid,hospital_code,queue_number FROM hospital_person_queue) t2
ON t1.cid = t2.cid
WHERE hospital_code = 11421
GROUP BY t2.cid 
ORDER BY queue_number"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result = mysqli_query($con, $sql1);
    $title = [];
    $value = [];
        while($row = mysqli_fetch_assoc($result)) {
            $title[] = $row['queue_number'];
            $value[] = $row['stotal'];
            // print_r($title);
        }
?>

<!-- แสดงข้อมูล Chart -->
<div id="branddate"></div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- javascript สำหรับเขียนคำสั่งเรียกใช้งาน apexcharts library -->
<script>

var options = {
          series: [{
          name: 'AstraZeneca',
          data: <?=json_encode($value);?>
        }],
          chart: {
          width: '100%',
          height: 200,
          type: 'bar',
          stacked: false,
        },
        colors:['#ffb31a'],
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '100%',
            endingShape: 'flat'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: false,
          curve: 'smooth'
        },
        xaxis: {
          type: 'numeric',
          categories: <?=json_encode($title,JSON_NUMERIC_CHECK);?>
        },
        yaxis: {
          show: false,
        },
        title: {
          text: 'คิวฉีด รพ.บางแก้ว',
          align: 'center',
          // offsetX: 110
        },
        tooltip: {
          x: {
            enabled: false,
          },
        },

        };

        var chartdate = new ApexCharts(document.querySelector("#branddate"), options);
        chartdate.render();
</script>