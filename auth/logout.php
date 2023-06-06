<?php
    session_start();
    if(isset($_POST['logOutSubmit'])){
        session_destroy();
        header('location: /lms/auth/login.php');
        exit();
    }
    
?>