<?php
require_once 'db.php';
$hos_name = "หหห";
// $sql = "SELECT vaccine_manufacturer,
// SUM(CASE When vaccine_reaction_symptom_id='1' Then 1 Else 0 End ) as a1
// FROM immunization_aefi_observe 
// group by vaccine_manufacturer
// order by vaccine_manufacturer_id='8',vaccine_manufacturer_id='6',vaccine_manufacturer_id='1',vaccine_manufacturer_id='7'"; //คำสั่ง เลือกข้อมูลจากตาราง report

//     $result = mysqli_query($con, $sql);
//     $title = [];
//     $value = [];
//     if (mysqli_num_rows($result) > 0) {
        
//         while($row = mysqli_fetch_assoc($result)) {
//             $title[] = $row['vaccine_manufacturer'];
//             $a1[] = $row['a1'];
//             // print_r($title);
//         }
//     }


    $sql_observe = "SELECT 	
    vaccine_manufacturer as title,
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ปวด บวม แดง ร้อน บริเวณที่ฉีด%' THEN 1 ELSE 0 END) AS aefi1, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ไข้%' THEN 1 ELSE 0 END) AS aefi2,
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ปวดศีรษะ%' THEN 1 ELSE 0 END) AS aefi3, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%เหนื่อย อ่อนเพลีย ไม่มีแรง%'   THEN 1 ELSE 0 END) AS aefi4, 
    SUM(CASE WHEN (vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ปวดกล้ามเนื้อ%' and vaccine_reaction_symptom_name or reaction_detail_text NOT LIKE '%ปวดกล้ามเนื้อ กล้ามเนื้ออ่อนแรง%') THEN 1 ELSE 0 END) AS aefi5, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ปวดกล้ามเนื้อ กล้ามเนื้ออ่อนแรง%'  THEN 1 ELSE 0 END) AS aefi6, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%คลื่นไส้%' THEN 1 ELSE 0 END) AS aefi7, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%อาเจียน%' THEN 1 ELSE 0 END) AS aefi8, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ท้องเสีย%' THEN 1 ELSE 0 END) AS aefi9, 
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ผื่น%' THEN 1 ELSE 0 END) AS aefi10, 
    SUM(CASE WHEN (vaccine_reaction_symptom_name or reaction_detail_text LIKE '%hypert%' or vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ความดัน%' or vaccine_reaction_symptom_name or reaction_detail_text LIKE '%BP%') THEN 1 ELSE 0 END) AS aefi11,
    SUM(CASE WHEN vaccine_reaction_symptom_name or reaction_detail_text LIKE '%ชา%' THEN 1 ELSE 0 END) AS aefi12
    FROM immunization_aefi_observe 
    -- WHERE ref_hospital_name = 'โรงพยาบาลพัทลุง'
    GROUP BY vaccine_manufacturer 
    ORDER BY vaccine_manufacturer_id='8',vaccine_manufacturer_id='6',vaccine_manufacturer_id='1',vaccine_manufacturer_id='7'";
    $result_observe = mysqli_query($con, $sql_observe);
    $title = [];
    $aefi_observe1 = [];
    if (mysqli_num_rows($result_observe) > 0) {
        
        while($row = mysqli_fetch_assoc($result_observe)) {
            $title[] = $row['title'];
            $aefi_observe1[] = $row['aefi1'];
            // print_r($title);
        }
    }
?>
<!-- แสดงข้อมูล Chart -->
<div id="stack-chart"></div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- javascript สำหรับเขียนคำสั่งเรียกใช้งาน apexcharts library -->
<script>
    var options = {
        series: [{
        name: 'ปวด บวม แดง ร้อน บริเวณที่ฉีด (Injection site reaction)',
        data: <?=json_encode($a1);?>
      }, {
        name: 'Striking Calf',
        data: [11]
      }, {
        name: 'Tank Picture',
        data: [22]
      }],
        chart: {
        type: 'bar',
        height: 350,
        stacked: true,
      },
      plotOptions: {
        bar: {
          horizontal: true,
        },
      },
      stroke: {
        width: 1,
        colors: ['#fff']
      },
      title: {
        text: 'AEFI ช่วงสังเกตอาการ(30 นาที)'
      },
      xaxis: {
        categories: <?=json_encode($title);?>,
        labels: {
          formatter: function (val) {
            return val + "K"
          }
        }
      },
      yaxis: {
        title: {
          text: undefined
        },
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return val + "K"
          }
        }
      },
      fill: {
        opacity: 1
      },
      legend: {
        position: 'top',
        horizontalAlign: 'left',
        offsetX: 40
      }
      };

      var stackchart = new ApexCharts(document.querySelector("#stack-chart"), options);
      stackchart.render();
</script>
