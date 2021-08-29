
<?php
require_once 'db.php';

$sql1 = "SELECT immunization_date,
SUM(CASE WHEN vaccine_manufacturer_id = 1 THEN 1 ELSE 0 END) AS vac1,
SUM(CASE WHEN vaccine_manufacturer_id = 6 THEN 1 ELSE 0 END) AS vac6,
SUM(CASE WHEN vaccine_manufacturer_id = 7 THEN 1 ELSE 0 END) AS vac7,
SUM(CASE WHEN vaccine_manufacturer_id = 8 THEN 1 ELSE 0 END) AS vac8,
count(*) AS stotal
FROM visit_immunization GROUP BY immunization_date"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result = mysqli_query($con, $sql1);
    $title = [];
    $value1 = [];
    $value2 = [];
    $value3 = [];
    $value4 = [];
    if (mysqli_num_rows($result) > 0) {
        
        while($row1 = mysqli_fetch_assoc($result)) {
            $title[] = $row1['immunization_date'];
            $value1[] = $row1['vac1'];
            $value2[] = $row1['vac6'];
            $value3[] = $row1['vac7'];
            $value4[] = $row1['vac8'];
            // print_r($title);
        }
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
          data: <?=json_encode($value1);?>
        },{
          name: 'Pfizer, BioNTech',
          data: <?=json_encode($value2);?>
        },{
          name: 'Sinovac Life Sciences',
          data: <?=json_encode($value3);?>
        },{
          name: 'Sinopharm',
          data: <?=json_encode($value4);?>
        }],
          chart: {
          width: '100%',
          height: 380,
          type: 'bar'
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '100%',
            endingShape: 'rounded'
          },
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
        title: {
          text: 'จำนวนการฉีดวัคซีน แยกตามยี่ห้อ (*สามารถคลิกลาก ย่อ-ขยาย ได้)',
          align: 'center',
          // offsetX: 110
        },
        tooltip: {
          x: {
            format: 'dd/MM/yyyy'
          },
        },

        };

        var chartdate = new ApexCharts(document.querySelector("#branddate"), options);
        chartdate.render();
</script>