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


$sql = "SELECT eoc_vaccine_group.person_type_name,eoc_target.ref_hospital_name,eoc_target.hospital_code,Target as sTarget,Dose1 as sDose1,Dose2 as sDose2,Dose3 as sDose3 FROM eoc_vaccine_group
INNER JOIN eoc_target
ON eoc_vaccine_group.group_number = eoc_target.group_number and eoc_vaccine_group.hospital_code = eoc_target.hospital_code 
where eoc_vaccine_group.person_type_name = '$i'
group by eoc_vaccine_group.ref_hospital_name  order by eoc_vaccine_group.hospital_code"; //คำสั่ง เลือกข้อมูลจากตาราง report

    $result = mysqli_query($con, $sql);
    $ref_hospital_name = [];
    $target = [];
    $dose1 = [];
    $dose2 = [];
    $dose3 = [];
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            // $ref_hospital_name[] = $row['ref_hospital_name'];
            $ref_hospital_name[] = str_replace("โรงพยาบาล","รพ.",$row['ref_hospital_name']);
            // $ref_hospital_name[] = str_replace("โรงพยาบาล","รพ.",$ref_hospital_name[]);
            $target[] = $row['sTarget'];
            $dose1[] = number_format(($row['sDose1']/$row['sTarget']*100)>100 ? '100' : ($row['sDose1']/$row['sTarget']*100) , 2, '.', ',');
            $dose2[] = number_format(($row['sDose2']/$row['sTarget']*100)>100 ? '100' : ($row['sDose2']/$row['sTarget']*100) , 2, '.', ',');
            $dose3[] = number_format(($row['sDose3']/$row['sTarget']*100)>100 ? '100' : ($row['sDose3']/$row['sTarget']*100) , 2, '.', ',');
            // print_r($title);
        }
    };

?>
  <style>
		<?php echo "#hos_count_chart{$round}{
		  margin: auto;
		}";
        ?>
  </style>

<!-- แสดงข้อมูล Chart -->
<?php echo"<div id='hos_count_chart{$round}'>
</div>";
?>


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
        annotations: {
        yaxis: [
            {
            y: 70,
            borderColor: 'red',
            label: {
                borderColor: '#red',
                style: {
                color: '#fff',
                background: '#red'
                },
                text: 'เป้าหมาย 70%'
            }
            }
        ]
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
            // return val + "%";
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
          <?php echo "text: ['ร้อยละของ{$i}ที่ได้รับวัคซีน','แยกรายอำเภอ จังหวัดพัทลุง ข้อมูล ณ วันที่ {$dt[0]}'],"; ?>
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

        var hos_count_chart = new ApexCharts(document.querySelector("<?php echo "#hos_count_chart{$round}"; ?>"), options);
        hos_count_chart.render();


</script>