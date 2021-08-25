<?php
switch($page){
    default : require 'page/covid/index.php';
    break;
    case "stock": require 'page/stock/stock.php';
    break;
    case "vaccine-dashboard": require 'page/vaccine/dashboard.php';
    break;
    case "vaccine-stat": require 'page/vaccine/stat.php';
    break;
    case "aefi-index": require 'page/aefi/index.php';
    break;
    case "report": require 'report.php';
    break;
}
?>