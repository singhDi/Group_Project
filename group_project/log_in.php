<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
session_start();


$processed_body = "";
if (!isset($_POST['submit'])){
    $email = "";
    $password = "";
}elseif(isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if($email === "") {
        $processed_body .= "email cannot be empty";
    }elseif($password === ""){
        $processed_body.="password is empty";
    }else{
        // Process itme with views = 0; seller's email passed from session
        if(exists($host,$user,$db_password,$database,$user_table,$email)){
            $user_object = is_matched($host,$user,$db_password,$database,$user_table,$email,$password);
            if($user_object !== null){
                $_SESSION['seller_email'] = $email;
                $_SESSION['old_password'] = $password;
                $processed_body.= header('Location: logged_in_main.php');
            }else{
                $processed_body.="email and password does not match";
            }
        }else{
            $processed_body.="Email does not exists in our database";
        }
    }
}


$form_body = <<<EOFORM
 <nav class="nav nav-pills red mb-2 p-2">\
            <a class=" navbar-brand" href="#">UMD-bay</a>

            <a class="nav-link " href="main.php">Home</a>

            <div class="btn-group hover">
                <a class="nav-link dropdown-toggle" id="active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#A8A2A2">
                    My Account
                </a>
                <div class="dropdown-menu black bg-info">
                    <a class="dropdown-item " href="log_in.php">Login</a>
                    <a class="dropdown-item" href="sign_up.php">Register New User</a>


                </div>
            </div>
        </nav>
		<div class="container ">
            <div class="bodyBackground pb-4 pt-3">
                <h4 class="text-center green mb-4 ">Welcome to the Log In Portal</h4>
               
				<form class="mt-4" action="{$_SERVER['PHP_SELF']}" method="post">
					<div class="container">
                        <div class="row">
                            <div  class="col-md-4">
                            </div>
                            <div class="col-md-4">
								<b>Email            : </b><input type="email" name="email" class="form-control" required autofocus ><br><br>
								<b>Password         : </b><input type="password" name="password"class="form-control" required><br><br>
							</div>
                            <div  class="col-md-4">
                            </div>
                        </div>
                        <div>
                            <div align="center">
								<input type="reset" class="btn btn-lg btn-info">
								<input type="submit" name="submit" value="Log In" class="btn btn-lg btn-info"><br>
								<div align="center" class="mt-3 ">
                                    <a class="text-success " href="sign_up.php">Register New User</a>
                                </div>
							</div>
						</div>
					</div>

				</form>
			</div>
			<footer id="footer" class=" p-3 footercolor">

                Made By: Kevin Chen  || Olivier Toujas || Dipisha Singh || Pradeep Sharma
            </footer>


		</div>
EOFORM;

$body = $form_body.$processed_body;
$page = generate_page($body,"Application Form");
echo $page;