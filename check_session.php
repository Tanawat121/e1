<?php
    session_start();
    if (!isset($_SESSION ['sess_username']) || !isset($_SESSION ['sess_id'])) {
        header("Location: login.php");
        exit();
    }
?>