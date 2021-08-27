<?php
switch($page){
    // default : require 'page/covid/index.php';
    default : require 'page/vaccine/dashboard.php';
    break;
    case "stock": require 'page/stock/stock.php';
    break;
    case "vaccine-dashboard": require 'page/vaccine/dashboard.php';
    break;
    case "vaccine-group": require 'page/vaccine/group.php';
    break;
    case "vaccine-group608": require 'page/vaccine/group608.php';
    break;
    case "vaccine-stat": require 'page/vaccine/stat.php';
    break;
    case "aefi-index": require 'page/aefi/index.php';
    break;
    case "report": require 'report.php';
    break;
}
?>