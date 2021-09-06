<?php include 'db.php';?>
<!doctype html>
<html lang="en">
  <head>
  	<title>COVID::พัทลุง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="images/favicon.ico">

    <!-- <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet"> -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;200;300&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">

		<!-- DataTable CDN -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
	<style>
		#progressbar {
		text-align: center;
		background-color: #f2f2f2;
		padding: 0px;
		position: relative;
		}

		#progressbar>div {
			background-color: #ffe680;
			height: 20px;
		}

		.progress-label {
			font-size: .8em;
			position: absolute;
			margin: 0;
			left: 0;
			right: 0;
			top: 50%;
			transform: translateY(-50%);
		}
		h1,h2,h3,h4,h5,h6 {
			font-family: 'Sarabun', sans-serif;
		};
		
	</style>
  </head>
  <body style="font-family: 'Sarabun', sans-serif;">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P2J6NNF"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
  <?php
                    $process=0;
                    $sql_process="SELECT * FROM vac_timestamp_proc 
                    WHERE table_name='eoc' AND id = (SELECT MAX(id) as date_max FROM vac_timestamp_proc WHERE table_name='eoc')";
                    $rs_process=mysqli_query($con,$sql_process);
                    if(mysqli_num_rows($rs_process)>=1){
                        $row = mysqli_fetch_assoc($rs_process);
                        if($row['proc_status']==1)
                            $process=1;
                    }        
                    if($process==1){

	?>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4">
		  		<h1><a href="index.php" class="logo">COVID <span>Phatthalung</span></a></h1>
	        <h5 class="text-white" style="font-family: 'Sarabun', sans-serif;">สสจ.พัทลุง</h5>
	        <ul class="list-unstyled components mb-5">
	          <!-- <li>
	            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">ข้อมูลระบาด</a>
	            <ul class="collapse list-unstyled show" id="pageSubmenu1">
                <li><a href="#"><span class=""></span>ยอดผู้ติดเชื้อรายวัน</a></li>
                <li><a href="#"><span class=""></span>Timeline</a></li>
	            </ul>
	          </li> -->
	          <li>
	            <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">วัคซีน</a>
	            <ul class="collapse list-unstyled show" id="pageSubmenu2">
					<li><a href="index.php?page=vaccine-dashboard"><span class=""></span>ข้อมูลสรุปการฉีดวัคซีน</a></li>
					<li><a href="index.php?page=vaccine-group"><span class=""></span>ข้อมูลสรุปกลุ่มเป้าหมาย</a></li>
					<li><a href="index.php?page=vaccine-group608"><span class=""></span>ข้อมูลสรุปกลุ่ม608</a></li>
					<li><a href="index.php?page=vaccine-queue"><span class=""></span>ข้อมูลการจองวัคซีน</a></li>
	            </ul>
	          </li>
			  <li>
	            <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">คงคลัง</a>
	            <ul class="collapse list-unstyled show" id="pageSubmenu3">
					<li><a href="index.php?page=inventory-summary"><span class=""></span>ยอดวัคซีนคงเหลือ</a></li>
					<li><a href="index.php?page=inventory-hos"><span class=""></span>ยอดวัคซีนคงเหลือแยกโรงพยาบาล</a></li>
					<li><a href="index.php?page=vaccine-daily"><span class=""></span>รายงานสถานการณ์รายวัน 608</a></li>
	            </ul>
	          </li>
	          <li>
	            <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">อาการไม่พึงประสงค์</a>
	            <ul class="collapse list-unstyled show" id="pageSubmenu4">
                	<li><a href="index.php?page=aefi-brand"><span class=""></span>แยกตามยี่ห้อวัคซีน</a></li>
					<li><a href="index.php?page=aefi-time"><span class=""></span>แยกตามเวลารายงาน</a></li>
					<li><a href="index.php?page=aefi-hos"><span class=""></span>แยกตามโรงพยาบาล</a></li>
					<li><a href="index.php?page=aefi-ddc"><span class=""></span>AEFI-DDC</a></li>
	            </ul>
	          </li>
			  
	        </ul>

	        <!-- <div class="mb-5">
						<h3 class="h6 mb-3">Subscribe for newsletter</h3>
						<form action="#" class="subscribe-form">
	            <div class="form-group d-flex">
	            	<div class="icon"><span class="icon-paper-plane"></span></div>
	              <input type="text" class="form-control" placeholder="Enter Email Address">
	            </div>
	          </form>
					</div> -->

	        <div class="footer d-none">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5" style="min-width : 1200px;">
                                <?php 
                                    if(isset($_GET['page'])){
                                        $page = $_GET['page'];
                                    } else {
                                        $page = "";
                                    }
                                    require 'case.php';
                                ?>
      </div>
		</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

	<!-- DataTable Script -->
	<!-- Button -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
	<script>
		$(document).ready(function() {
		var table = $('#hosanother').DataTable( {
			lengthChange: false,
			buttons: [ 'copy', 'excel' ]
		} );
	
		table.buttons().container()
			.appendTo( '#hosanother_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<script>
		$(document).ready(function() {
		var table = $('#queue').DataTable( {
			lengthChange: false,
			"pageLength": 11,
			buttons: [ 'copy', 'excel' ]
		} );
	
		table.buttons().container()
			.appendTo( '#queue_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<script>
		$(document).ready(function() {
		var table = $('#invent').DataTable( {
			order: [],
			lengthChange: false,
			paging: false,
			ordering: false,
			info: false,
			searching: false,
			buttons: [ 'copy', {
                extend: 'excelHtml5',
                title: <?php $ssdate = "vaccine_inventory_date_".$sdate; echo json_encode($ssdate);?>
            } ]
		} );
	
		table.buttons().container()
			.appendTo( '#invent_wrapper .col-md-6:eq(0)' );
		} );
	</script>
	<script>
		$(document).ready(function() {
		var table = $('#invent-summary').DataTable( {
			order: [[ 0, 'asc' ]],
			lengthChange: true,
			searching: false,
			ordering: false,
			pageLength: 15,
			buttons: [ 'copy',{
                extend: 'excelHtml5',
                title: <?php $nndate = "summary_".date("Y/m/d_H:i:s"); echo json_encode($nndate);?>
            } ]
		} ).page('last').draw('page');
	
		table.buttons().container()
			.appendTo( '#invent-summary_wrapper .col-md-6:eq(0)' );
		} );
	</script>

<script>
		$(document).ready(function() {
		var table = $('#invent-hos').DataTable( {
			order: [[ 0, 'asc' ]],
			lengthChange: true,
			searching: false,
			ordering: false,
			pageLength: 15,
			buttons: [ 'copy',{
                extend: 'excelHtml5',
                title: <?php $xxdate = "summary_".$vacbrand."_".date("Y-m-d"); echo json_encode($xxdate);?>
            } ]
		} ).page('last').draw('page');
	
		table.buttons().container()
			.appendTo( '#invent-hos_wrapper .col-md-6:eq(0)' );
		} );
	</script>
<?php
                    }else{
                        echo "<center><div class=\"parent\"><img class=\"child\" src='images/moph-logo.gif'  ></div><br></center>";
                        echo "<center> <h5  style=\"font-family: 'Sarabun', sans-serif;\"><font color='red'>ระบบกำลังประมวลผล กรุณารอสักครู่...</font><font color='blue'> กรุณากลับมาหน้านี้อีกครั้งหลังจากระบบประมวลผลเสร็จ</font></h5></center>";
                        // echo "<script> location.replace(\"hospital_type_vac_hdc.php\") </script>";

                    }
?>

  </body>
</html>

<!-- ทดสอบ -->