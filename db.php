<?php
    $base_url='http://localhost/jrshop/jrshop';
    $host="localhost";
    $user="root";
    $pw="";
    $dbname="jrshop";
    $conn = new mysqli($host, $user, $pw, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>