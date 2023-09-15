<?php
    session_start();
    session_destroy();

    header('location: /ISDProject/frontend/home.php');
    exit;
?>