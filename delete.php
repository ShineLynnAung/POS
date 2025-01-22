<?php
    require_once("models/stocks.php");
    $result = stocks::delete($_GET['id']);
    if($result){
        header("Location: stock.php");
    }
?>