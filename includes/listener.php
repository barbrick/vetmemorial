<?php
    include('../includes/class.worker.php');
    $worker = new Worker();

    // Create User
    if (isset($_POST['createUser']) && $worker->checkSession()) {
        $worker->createUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['fname'], $_POST['lname']);
    }
    
    // Edit User
    if (isset($_POST['editUser']) && $worker->checkSession()) {
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
    
    // Add News
    if (isset($_POST['addNews']) && $worker->checkSession()) {
        $worker->addNews($_POST['title'], $_POST['content'], date("Y-m-d", $_POST['date']));
    }
    
    // Edit News
    if (isset($_POST['editNews']) && $worker->checkSession()) {
        $worker->editNews($_POST['newsid'], $_POST['title'], $_POST['content'], date("Y-m-d", $_POST['date']));
    }
    
    // Delete News
    if (isset($_POST['deleteNews']) && $worker->checkSession()) {
        $worker->deleteNews($_POST['newsid']);
    }
    
    // Edit Page
    if (isset($_POST['editPage']) && $worker->checkSession()) {
        $worker->editPage($_POST['pageid'], $_POST['title'], $_POST['description'], $_POST['content']);
    } 
    
?>