<?php
    include('../includes/class.worker.php');
    $worker = new Worker();

    // Create User
    if (isset($_POST['createUser'])) {
        $worker->createUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['fname'], $_POST['lname']);
    }
    
    // Edit User
    if (isset($_POST['editUser'])) {
        $worker->editUser($_SESSION['username'], $_POST['password'], $_POST['conf']);
    }
    
    // Forgot Password
    if (isset($_POST['forgotPass'])) {
        $worker->resetPassword($_POST['email']);
    }
    
    // Login User
    if (isset($_POST['login'])) {
        $worker->login($_POST['username'], $_POST['password']);
    }
    
    // Logout User
    if (isset($_POST['logout'])) {
        $worker->logout();
    }
?>