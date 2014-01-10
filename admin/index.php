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

        </header>
        <!-- End Header -->


        <!-- Start Content -->
        <section class="content">

            <div class="row-fluid">

                <div class="span12">
                    <div class="title">
                        <h3 class="text-center design">Admin Login</h3>
                        <hr />
                    </div>
                </div>
            </div>

          <div class="row-fluid login">

            <form method="POST" action="../includes/listener.php">
              <input type="text" class="text-center marginLeftNone" name="username" placeholder="Username" autofocus="" required=""/>
              <br/>
              <input type="password" class="text-center marginLeftNone" name="password" placeholder="Password" required=""/>
              <br/>
              <br />
              <input type="submit" class="text-center submit marginLeftNone" name="login" value="Login"/>
            </form>

          </div>
        </section>
        <!-- End Content -->

        <hr>

        <!-- Start Footer -->
        <footer class="footer">
            <p>&copy; <?php echo date("Y") ?> <a href="http://www.veteranmemorialpark.com" class="title">Veterans Memorial Park</a> <span class="pull-right">Designed by: <a href="http://www.gillamwright.com" target="_blank" class="title">Shawn Gillam-Wright</a> &amp; <a href="http://www.barbrick.com" target="_blank" class="title">Trevor Barbrick</a></span></p>
        </footer>
        <!-- End Footer -->

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
