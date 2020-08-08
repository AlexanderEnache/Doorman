<?php
    $hn = 'localhost'; //hostname
    $db = 'enachea_final-project'; //database
    $un = 'enachea_final-project'; //username
    $pw = 'password'; //password
    
    $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) die($conn->connect_error);
?>