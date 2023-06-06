<?php

$conn = mysqli_connect('localhost','root','','lms');

if(!$conn){
    die("Connection Failed");
}

if(isset($_POST['contactSubmit'])){

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$sql = "INSERT INTO contactUs (`cont_fname`,`cont_lname`,`cont_email`,`cont_phone`,`cont_message`) VALUES ('$fname', '$lname', '$email', '$phone', '$message')";
$res = mysqli_query($conn, $sql);

if ($res){
    echo "Success! Your message has been sent.";
    
    // Redirect with success message
    header("Location: /lms/contactUs.php");
    exit;
}
else{
    echo "Failed";
}
}


?>