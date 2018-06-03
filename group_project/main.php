<!DOCTYPE html>
<html>
<head>
    <title>Company Name</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel='stylesheet' href='css/style.css'/>
</head>

<body>
    <?php
        session_start();
        $_SESSION['seller_email'] = "";
        $_SESSION['old_password'] = "";
    ?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">UMD-bay</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">My Account
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="log_in.php">Login</a></li>
                    <li><a href="sign_up.php">Sign Up</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <img src="clothing.jpg" alt="Clothing" align="middle">
            <div class="carousel-caption">
                <h3>Clothing</h3>
                <p>Find the cheapest prices!</p>
            </div>
        </div>

        <div class="item">
            <img src="shoes.jpg" alt="Shoes" class="center">
            <div class="carousel-caption">
                <h3>Shoes</h3>
                <p>Find what fits your feet!</p>
            </div>
        </div>

        <div class="item">
            <img src="accessories.jpg" alt="Accessories" class="center">
            <div class="carousel-caption">
                <h3>Accessories</h3>
                <p>To compliment your style!</p>
            </div>
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

// Testing code for display


// done with testing





<footer id="footer">
    <hr>
    Made By: Kevin Chen, Olivier Toujas, Dipisha Singh, Pradeep Sharma
</footer>
</body>
</html>