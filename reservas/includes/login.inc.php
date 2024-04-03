<?php
session_start();
if(isset($_POST['btn_login'])){
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $_SESSION['emailL'] = $email;
    
    include('../classes/login-ctrl.classes.php');
    $login = new LoginCtrl($email,$pwd);
    $login -> loginUser();

    // On success, back to main page
    unset($_SESSION['emailL']);
    header("location: ../");

    
} else {
    header("Location: ../");
}