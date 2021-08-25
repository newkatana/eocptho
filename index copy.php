<?php include 'db.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link href="css/sidebars.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 1200px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      body{ font-family: 'Kanit', sans-serif;};

    </style>
    <link rel="shortcut icon" href="001.png" />
    <title>EOC::COVID-19 พัทลุง</title>
  </head>
  <body>
    <div class="d-flex flex-row">
        <div class="p-3 bg-white" style="min-width: 250px;">
            <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-5 fw-semibold">EOC Phatthalung</span>
            </a>
            <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                ข้อมูลระบาด
                </button>
                <div class="collapse show" id="home-collapse">
                <!-- <div class="collapse" id="home-collapse"> -->
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#" class="link-dark rounded">ยอดผู้ติดเชื้อรายวัน</a></li>
                    <li><a href="#" class="link-dark rounded">Timeline</a></li>
                </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="true">
                วัคซีน
                </button>
                <div class="collapse show" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="index.php?page=vaccine-stat" class="<?php echo ($_SERVER['QUERY_STRING'] == 'page=vaccine-stat' ? '':'link-dark ') ?> rounded ">ข้อมูลสรุปการฉีดวัคซีน</a></li>
                    <li><a href="index.php?page=stock" class="<?php echo ($_SERVER['QUERY_STRING'] == 'page=stock' ? '':'link-dark ') ?> rounded ">ยอดวัคซีนคงเหลือ</a></li>
                </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#aefi-collapse" aria-expanded="true">
                อาการไม่พึงประสงค์
                </button>
                <div class="collapse show" id="aefi-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="index.php?page=aefi-index" class="<?php echo ($_SERVER['QUERY_STRING'] == 'page=aefi' ? '':'link-dark ') ?> rounded ">ข้อมูล AEFI</a></li>
                </ul>
                </div>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
                Account
                </button>
                <div class="collapse " id="account-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="#" class="link-dark rounded">New...</a></li>
                    <li><a href="#" class="link-dark rounded">Profile</a></li>
                    <li><a href="#" class="link-dark rounded">Settings</a></li>
                    <li><a href="#" class="link-dark rounded">Sign out</a></li>
                </ul>
                </div>
            </li>
            </ul>
        </div>
        
              <!-- Page content-->
              <div class="" style="min-width: 1200px;">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="js/sidebars.js"></script>
    
  </body>
</html>
            