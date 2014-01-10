<?php
    include('includes/class.display.php');
    $display = new Display();
    $page = $display->getPage(2);
?>
<!doctype html>

<html>
<!-- HEAD -->
<head>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $page->description; ?>">
    <meta name="viewport" content="width=device-width">
    <title>Veterans Memorial Park | <?php echo $page->title; ?></title>

    <!-- Authors -->
    <link rel="author" href="https://plus.google.com/+TrevorBarbrick" />
    <link rel="author" href="https://www.gillamwright.com" />



    <!-- Styles -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/pagination.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/lightbox.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<!-- BODY -->
<body>

    <!-- Start Container -->
    <div class="container">

        <!-- Start Header -->
        <header class="masthead">

            <div class="row-fluid">

                <div class="logo span5 pull-left">
                    <img src="images/siteLogo.png" alt="SiteLogo" class="pull-left" />

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

                        <li><a href="index.php">Home</a></li>
                        <li class="active"><a href="about.php">About</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Memorial <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">Who can be remembered?</a>
                                        <a href="#">To have a name listed</a>
                                        <a href="#">View names on memorial</a>
                                    </li>
                                </ul>
                        </li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact</a></li>


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

                <div class="span12">
                     <div class="title">
                        <h3 class="text-center design">About Veterans Memorial Park</h3>
                        <hr />
                    </div>

                    <div class="content">

                        <p>
                         The Veterans Memorial Park was Founded and designed by Dr. Karen Ewing 
                        </p>

                        <p>
                        Three intersecting gardens in the form of a Celtic flower create a living memorial to those who served. The Garden of Sorrows, The Garden of Remembrance and the Garden of Hope. The entrance to the Park allows access to each garden individually.
                        </p>

                        <p>
The Garden design invites the visitor to first enter the Garden on the left, The Garden of Sorrows. John Oxenham's Poem "Tread Softly Here" sets the tone of this garden designed as a World War I trench.  Visitors experience the illusion of stepping down into the trench. Sandbags hold back the black mulch covered earth. To the right red roses climb a barbed wire trellis isolating the visitor. The landscape is black and barren interspersed with occasional black iris ,black tulip, bleeding heart or red poppy. Corkscrew Hazels, weeping juniper and "X" cross barriers interrupt the barren landscape and an upturned soldiers helmet poses a stark reminder of the sacrifice. At intervals vignettes of soldiers from this area will be displayed.
                        </p>

                        <p>
A corner turned "away from war" and the garden softens as you walk out of the trench and enter the Garden of Remembrance. Here flowering trees, shrubs, daisies, lilies and forget-me-nots among others provide sights and scents of years past, allowing an attitude of Remembrance. Benches surround the central podium where names of those who served mark each stone.
                        </p>

                        <p>
From the Garden of Remembrance visitors enter the Garden of Hope. This garden is a colourful international garden. visitors will note the presence of trees, shrubs and plants from many countries including Japanese Maple, Korean Lilacs, Siberian Iris, and German Edelweiss all speaking to the hope of reconciliation, with hope for the future and thankfulness for the lives and the freedoms we now enjoy.
                        </p>

                        <p>
                            At night a solar powered floodlight will announce the name of the park. The parking area itself will house a sign recognizing corporate donations, a sign announcing the name and purpose of the park and a flag pole. The floodlight and stencil will be housed in a locked enclosed box with a donation box.
                        </p>

                        <p>
                             All areas of the park are wheelchair accessible. The park's monument will be inclusive for those who served their country. The Park allows an experience of the sorrows, the remembrance, and of the hope for the future. Remembering that every freedom we enjoy, every measure of land we call home, was fought for and won.
                        </p>

                    </div>

                    <div class="slideshow text-center">
                        <br />
                        <p>
                            <b>Please view the slide show to see the design of the park.</b>
                        </p>

                        <embed src="files/warmemorial.swf" height="400" width="800" />

                    </div>

                </div>
              
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
   <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui-1.10.3.min.js"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/lightbox-2.6.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

</body>
</html>
