<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
session_start();
$processed_body = "";
if (!isset($_POST['submit']) && !isset($_POST['return_to_main'])){
   $first_name = "";
   $middle_name = "";
   $last_name = "";
   $phone_number = "";
   $email = "";
   $password = "";
   $confirm_password = "";

}elseif(isset($_POST['submit'])) {
    $first_name = trim($_POST['firstname']);
    if(!isset($_POST['middlename']) || trim($_POST['middlename'])=== ""){
        $middle_name = "";
    }else{
        $middle_name    = trim($_POST['middlename']);
    }
    $last_name =  trim($_POST['lastname']);
    $phone_number =  trim($_POST['phonenumber']);
    $email = trim($_POST['email']);
    $password =  trim($_POST['password']);
    $confirm_password =  trim($_POST['confirmpassword']);
    // new stuff
    

    if($first_name === "") {
        $processed_body .= "first name cannot be empty";
    }elseif ($last_name === ""){
        $processed_body.="last name cannot be empty";
    }elseif ($phone_number === ""){
        $processed_body.="phone number cannot be empty";
    }elseif ($password === ""){
        $processed_body.="password cannot be empty";
    }elseif ($confirm_password === ""){
        $processed_body.="you confirm password box is empty";
    }elseif ($password !== $confirm_password){
        $processed_body.="your password and confirm password do not match";
    }else{
        if(exists($host,$user,$db_password,$database,$user_table,$email)){
            $processed_body.="user already exists with provided email";
        }else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $fileToInsert = trim($_POST["image"]);
                $docMimeType = "image/jpeg";
                    $fileData = addslashes(file_get_contents($fileToInsert));


          $user_object = add_to_database($host,$user,$db_password,$database,$user_table,$first_name,$middle_name,$last_name,$email,$phone_number,$hashed_password, $fileToInsert, $docMimeType, $fileData);
            if(exists($host,$user,$db_password,$database,$user_table,$email)){
                $user_object = is_matched($host,$user,$db_password,$database,$user_table,$email,$password);
                if($user_object !== null){
                    $_SESSION['seller_email'] = $email;
                    $_SESSION['old_password'] = $password;
                    $processed_body.= header('Location: logged_in_main.php');
                }else{
                    $processed_body.="something went wrong with database while processing the information";
                }
            }else{
                $processed_body.="something went wrong with system while adding the information into database";
            }
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
        <h4 class="text-center green mb-4 ">Welcome to the Registration Page</h4>
        
			<form class="mt-4" action="{$_SERVER['PHP_SELF']}" method="post">
				<div class="container">
                    <div class="row">
                        <div  class="col-md-2">
                        </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold">First Name</label>
                                <input type="text" name= "firstname" value="$first_name" class="form-control"required>
                            </div>
							<div class="col-md-3">
                                <label  class="font-weight-bold">Middle Name</label>
                                <input type="text" name = "middlename" value="$middle_name" class="form-control">

                            </div>
							<div class="col-md-3">
                                <label  class="font-weight-bold">Last Name</label>
                                <input type="text" name = "lastname" value="$last_name" class="form-control" required>

                            </div>
							<div  class="col-md-2">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div  class="col-md-2">
                            </div>
                            <div class="col-md-4">

                                <label class="font-weight-bold">Phone Number</label>
                                <input type="tel" name="phonenumber" value="$phone_number" pattern="[0-9]{10}" class="form-control"required>

                            </div>
                            <div class="col-md-4">
                                <label  class="font-weight-bold">Email</label>
                                <input type="email" name ="email" value="$email" class="form-control">

                            </div>
                            <div  class="col-md-2">
                            </div>
                        </div>
                            

                        <div class="row mt-3">
                            <div  class="col-md-2">
                            </div>
                            <div class="col-md-4">

                                <label class="font-weight-bold">Password</label>
                                <input type="password" name="password" value="$password" class="form-control">

                            </div>
                            <div class="col-md-4">
                                <label  class="font-weight-bold">Confirm Password</label>
                                <input type="password" name="confirmpassword" value="$confirm_password" class="form-control">


                            </div>

                            <div  class="col-md-2">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div  class="col-md-2">
                            </div>
                            <div class="col-md-4">

                                <label  class="font-weight-bold">Image Name</label>
                                <input type="text" name="image" class="form-control" size="10">
                            </div>
                            </div>

						<div class="mt-4">
                            <div align="center">
								<input type="reset" class="btn btn-lg btn-info">
								<input type="submit" name="submit" value="Sign Up" class="btn btn-lg btn-info">
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