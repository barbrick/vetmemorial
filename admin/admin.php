<?php
    include('../includes/class.worker.php');
    $worker = new Worker();
    
    if ($worker->checkSession()) {
        // User is authorized
    } else {
       header("Location:index.php");
    }
?>
<!doctype html>

<html>
<!-- HEAD -->
<head>
    <meta charset="utf-8">
    <meta name="description" content="Veterans Memorial Park in Bass River Nova Scotia. A living memorial to those who served">
    <meta name="viewport" content="width=device-width">
    <title>Veterans Memorial Park | Bass River, NS</title>

    <!-- Authors -->
    <link rel="author" href="https://plus.google.com/+TrevorBarbrick" />
    <link rel="author" href="https://www.gillamwright.com" />



    <!-- Styles -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/grid.css">
    <link rel="stylesheet" href="../css/pagination.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/lightbox.css">
    <link rel="icon" type="image/png" href="../images/favicon.png">
</head>

<!-- BODY -->
<body>

    <!-- Start Container -->
    <div class="container">

        <!-- Start Header -->
        <header class="masthead">

            <div class="row-fluid">

                <div class="logo span5 pull-left">
                    <img src="../images/siteLogo.png" alt="SiteLogo" class="pull-left" />

                </div>

                <div class="headerText span5 offset1 text-right">
                    <h3 class="title">Veterans Memorial Park</h3>
                    <h5 class="text-right">A living memorial to those who served</h5>
                    <h6>Bass River, Nova Scotia</h6>

                </div>

            </div>


            <!-- Start Navigation -->
            <nav class="navbar">
                <div class="navbar-inner">
                    <ul class="nav">

                           <li><a href="#">Link 1</a></li>
                        <li><a href="#">Link 2</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Link 3 <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Dropdown Link 1</a>
                                        <a href="#">Dropdown Link 2</a>
                                        <a href="#">Dropdown Link 3</a>
                                    </li>
                                </ul>
                        </li>
                        <li class="#"><a href="gallery.html">Link 4</a></li>
                        <li><a href="#" onclick="$('#logoutForm').submit();return false;">Logout</a></li>


                        <!---->

                    </ul>
                </div>
            </nav>
            <!-- End Navigation -->
        </header>
        <!-- End Header -->


        <!-- Start Content -->
        <section class="content">
            <div class="row-fluid">
              
            </div>
        </section>
        <!-- End Content -->

        <hr>

        <!-- Start Footer -->
        <footer class="footer">
            <p>&copy; <?php echo date("Y") ?> <a href="http://www.veteranmemorialpark.com" class="title">Veterans Memorial Park</a> <span class="pull-right">Designed by: <a href="http://www.gillamwright.com" target="_blank" class="title">Shawn Gillam-Wright</a> &amp; <a href="http://www.barbrick.com" target="_blank" class="title">Trevor Barbrick</a></span></p>
        </footer>
        <!-- End Footer -->
        <form id="logoutForm" action="../includes/listener.php" method="POST" >
            <input type="hidden" name="logout"/>
        </form>
    </div>
    <!-- End Container -->

    <!-- JS -->
    <script src="../js/jquery-1.10.2.min.js"></script>
    <script src="../js/jquery-ui-1.10.3.min.js"></script>
    <script src="../js/dropdown.js"></script>
    <script src="../js/lightbox-2.6.min.js"></script>
    <script src="../js/modernizr.custom.js"></script>

</body>
</html>
