<!DOCTYPE html>
<html lang="en">
<head>
<title>JavaScript - read JSON from URL</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="mypanel"></div>


    <?php
            //  $url = "https://covid19.ddc.moph.go.th/api/Cases/today-cases-by-provinces";
            
            $file = "https://covid19.ddc.moph.go.th/api/Cases/timeline-cases-by-provinces";
            $data = file_get_contents($file,true);
            $result = json_decode($data);

            end($result);
            $lastKey = key($result);

            echo $lastKey;
                echo '<pre>';
                print_r($result[33]);
                echo '</pre>';
            $i = 10953;
            while($i <= $lastKey){
            echo '<pre>';
                // print_r($result[33]);
            echo '<br>วันที่ ';
                print_r($result[$i]->txn_date);
            echo '<br>จังหวัด ';
                print_r($result[$i]->province);
            echo '<br>ผู้ป่วยรายใหม่ ';
                print_r($result[$i]->new_case);
            echo '<br>ผู้ป่วยสะสม ';
                print_r($result[$i]->total_case);
            echo '<br>เสียชีวิตรายใหม่ ';
                print_r($result[$i]->new_death);
            echo '<br>เสียชีวิตสะสม ';
                print_r($result[$i]->total_death);
            echo '</pre>';
            $i += 78;
            }

            ?>
</body>
</html>