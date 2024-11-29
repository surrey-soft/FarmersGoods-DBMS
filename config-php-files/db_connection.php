<?php 

    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $dbName ="dbms-farmers-goods";
    
    try{
        $con = mysqli_connect($hostName,$userName,$password,$dbName,3309);     
    }  
    catch(Exception $e){
        echo "An exception occurred: ".$e->getMessage();
        die ("Connection Error");
    }
    
?>