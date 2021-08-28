<style>
    </style>
<div class="card p-3 border-0" style="background: linear-gradient(to right, #3333cc 0%, #0066ff 100%);">
<h4 class="text-white">ข้อมูลการจองฉีดวัคซีน จังหวัดพัทลุง</h4>
<h6 class="text-white">ประจำวันที่ <?php 
    $datadate = "SELECT max(date_end) as date FROM vac_timestamp_proc 
    WHERE vac_timestamp_proc.table_name='eoc' and vac_timestamp_proc.proc_status='1'";
    $query_time = mysqli_query($con,$datadate);
    while($row = mysqli_fetch_assoc($query_time)){
        echo DateThai(date($row['date']));
}
?></h6>
</div><hr>
<div class="container-fluid">

<table id="queue" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ลำดับที่</th>
                <th>รหัสโรงพยาบาล</th>
                <th>ชื่อโรงพยาบาล</th>
                <th>จำนวนฉีดได้ต่อวัน</th>
                <th>queue</th>
                <th>slot</th>
                <th>รวม</th>
                <th>เปอร์เซ็น</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql="SELECT * FROM eoc_ratetarget";
            $result=mysqli_query($con,$sql);
            $i=1;
            while($array=mysqli_fetch_array($result)){
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $array['hospital_code']; ?></td>
                        <td><?php echo $array['hospital_name']; ?></td>
                        <td><?php echo number_format($array['rate'], 0); ?></td>
                        <td><?php echo number_format($array['queue'], 0); ?></td>
                        <td><?php echo number_format($array['slot'], 0); ?></td>
                        <td><?php echo number_format(($array['queue']+$array['slot']), 0); ?></td>
                        <td><?php echo number_format(($array['queue']+$array['slot'])/$array['rate'], 2); ?></td>
                    </tr>
            <?php
            $i++;
            }
            ?>
        </tbody>
        <tfoot>
                <tr>
                    <th>ลำดับที่</th>
                    <th>รหัสโรงพยาบาล</th>
                    <th>ชื่อโรงพยาบาล</th>
                    <th>จำนวนฉีดได้ต่อวัน</th>
                    <th>queue</th>
                    <th>slot</th>
                    <th>รวม</th>
                    <th>เปอร์เซ็น</th>
                </tr>
        </tfoot>
    </table>

</div>