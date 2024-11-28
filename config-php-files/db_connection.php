<?php 

    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $dbName ="dbms-farmers-goods";
    
    try{
        $con = mysqli_connect($hostName,$userName,$password,$dbName,3306);     
    }  
    catch(Exception $e){
        echo "An exception occurred: ".$e->getMessage();
        die ("Connection Error");
    }
    
?>


<!-- Shakil-setup -->
<!-- $con = mysqli_connect($hostName,$userName,$password,$dbName,3306); -->