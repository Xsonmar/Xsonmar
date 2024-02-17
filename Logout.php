<?php 
    
    session_start(); // start the session
    session_unset(); // Unset the Data
    session_destroy(); // Destroy the session
    header("Location:index.php");
    exit();
?>