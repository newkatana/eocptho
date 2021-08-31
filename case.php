<?php
switch($page){
    // default : require 'page/covid/index.php';
    default : require 'page/vaccine/dashboard.php';
    break;
    case "vaccine-dashboard": require 'page/vaccine/dashboard.php';
    break;
    case "vaccine-group": require 'page/vaccine/group.php';
    break;
    case "vaccine-group608": require 'page/vaccine/group608.php';
    break;
    case "vaccine-daily": require 'page/vaccine/daily.php';
    break;
    case "aefi-brand": require 'page/aefi/brand.php';
    break;
    case "aefi-time": require 'page/aefi/time.php';
    break;
    case "aefi-ddc": require 'page/aefi/aefi-ddc.php';
    break;
    case "aefi-hos": require 'page/aefi/hos.php';
    break;
    case "inventory": require 'page/stock/inventory.php';
    break;
    case "inventory-summary": require 'page/stock/summary.php';
    break;
    

    case "report": require 'report.php';
    break;
    // dev got
    case "vaccine-queue": require 'page/vaccine/queue.php';
    break;
}
?>