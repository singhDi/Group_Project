<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";
session_start();
$seller_email = $_SESSION['seller_email'];
$seller_password = $_SESSION['old_password'];
$user_object = is_matched($host,$user,$db_password,$database,$user_table,$seller_email,$seller_password);
$fn = $user_object->get_first_name();
$mn = $user_object->get_middle_name();
$ln = $user_object->get_last_name();
$eml = $user_object->get_email();
$pn = $user_object->get_phone_number();

    $db = connectToDB($host, $user, $db_password, $database);


    $sqlQuery = "select docName from $user_table where email = '{$eml}'";
    $result = mysqli_query($db, $sqlQuery);
    if ($result) {
        $array = mysqli_fetch_assoc($result);
        $picture = $array['docName'];
    } 
        
    /* Closing */
    mysqli_close($db);
$info=<<<EOINFO
    <nav class="nav nav-pills red mb-2 p-2">
    <a class=" navbar-brand" href="#">UMD-bay</a>

    <a class="nav-link " href="logged_in_main.php">Home</a>

    <div class="btn-group hover">
    <a class="nav-link dropdown-toggle" id="active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#A8A2A2">
    My Account
    </a>
    <ul class="dropdown-menu black bg-info">
                    <li><a href="view_profile.php">View Profile</a></li>
                    <li><a href="update_profile.php">Update Profile</a></li>
                    <li><a href="show_my_items.php">Show My Items</a></li>
                    <li><a href="main.php">Logout</a></li>
                </ul>
    </div>
    </div>
    <a class="nav-link " href="buy_items.php">Buy</a>
    <a class="nav-link " href="submit_item.php">Sell</a>
    </nav>


    <div class="container ">
    <div class="bodyBackground pb-4 pt-3">
        <h4 class="text-center green mb-4 ">Your Profile</h4>
        <div align="center">
        <img src="$picture" alt="Image To Display" height="100px" height="100px" align="center"><br><br>
        </div>

        
			<form class="mt-4" action="{$_SERVER['PHP_SELF']}" method="post">
				<div class="container">
                    <div class="row">
                        <div  class="col-md-2">
                        </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">First Name:</label> $fn
                            </div>
							<div class="col-md-3">
                                <label  class="font-weight-bold">Middle Name:</label>$mn

                            </div>
							<div class="col-md-3">
                                <label  class="font-weight-bold">Last Name:</label> $ln

                            </div>
							<div  class="col-md-2">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div  class="col-md-2">
                            </div>
                            <div class="col-md-4">

                                <label class="font-weight-bold">Phone Number:</label>  $pn
                                

                            </div>
                            <div class="col-md-4">
                                <label  class="font-weight-bold">Email</label>
                                 $eml

                            </div>
                            <div  class="col-md-2">
                            </div>
                        </div>

                        
						<div class="mt-4">
                            <div align="center">
                                <form action="logged_in_main.php" method="post">
								<input type="submit" name="back" value="Back" class="btn btn-lg btn-info">
                                </form>
            
								
							 </div>
						</div>
                    </div>

			
	</div>
	<footer id="footer" class=" p-3 footercolor">

                Made By: Kevin Chen  || Olivier Toujas || Dipisha Singh || Pradeep Sharma
            </footer>
</div>

                
                <
    
EOINFO;
if(isset($_POST['back'])){
    $info.= header('Location: logged_in_main.php');
}

$page = generate_page($info);
echo $page;


function connectToDB($host, $user, $password, $database) {
    $db = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo "Connect failed.\n".mysqli_connect_error();
        exit();
    }
    return $db;
}