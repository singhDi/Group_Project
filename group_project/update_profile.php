<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";
session_start();

$seller_email = $_SESSION['seller_email'];
$seller_password = $_SESSION['old_password'];

$processed_body = "";
if (!isset($_POST['submit'])){
    $user_object = is_matched($host,$user,$db_password,$database,$user_table,$seller_email,$seller_password);
    $first_name     = $user_object->get_first_name();
    $middle_name    = $user_object->get_middle_name();
    $last_name      = $user_object->get_last_name();
    $email          =$user_object->get_email();
    $phone_number = $user_object->get_phone_number();
    $password = $seller_password;
    $confirm_password = $seller_password;
}elseif(isset($_POST['submit'])) {
    $first_name     = trim($_POST['firstname']);
    if(!isset($_POST['middlename']) || trim($_POST['middlename'])=== ""){
        $middle_name = "";
    }else{
        $middle_name    = trim($_POST['middlename']);
    }
    $last_name      = trim($_POST['lastname']);
    $email          = trim($_POST['email']);
    $phone_number = trim($_POST['phonenumber']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirmpassword']);
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
        if($email !== $seller_email && exists($host,$user,$db_password,$database,$user_table,$seller_email)){
            $processed_body.="new email belongs to some other user";
        }else{
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if($seller_email !== $email){
                $user_object = add_to_database($host,$user,$db_password,$database,$user_table,$first_name,$middle_name,$last_name,$email,$phone_number,$hashed_password);
                if(exists($host,$user,$db_password,$database,$user_table,$email)){
                    $user_object = is_matched($host,$user,$db_password,$database,$user_table,$email,$password);
                    if($user_object !== null){
                            //copy everything from old email to new one and delete everything associated with old email
                            copy_data($host,$user,$db_password,$database,$item_table,$seller_email,$email);
                            delete_user_from_database($host,$user,$db_password,$database,$user_table,$seller_email);
                        $_SESSION['seller_email'] = $email;
                        $_SESSION['old_password'] = $password;
                        $processed_body.= header('Location: logged_in_main.php');
                    }else{
                        $processed_body.="something went wrong with database while processing the information";
                    }
                }else{
                    $processed_body.="something went wrong with system while adding the information into database";
                }
            }else{
                $old_user = is_matched($host,$user,$db_password,$database,$user_table,$seller_email,$seller_password);
                $new_user = new User_Object($first_name,$middle_name,$last_name,$email,$phone_number,$hashed_password);
                $user_object = update_user($host,$user,$db_password,$database,$user_table,$email,$old_user,$new_user);
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
}



$form_body = <<<EOFORM
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
    <a class="nav-link " href="buy_items.php">Buy</a>
    <a class="nav-link " href="submit_item.php">Sell</a>
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
						<div class="mt-4">
                            <div align="center">
								<input type="submit" name="submit" value="Update" class="btn btn-lg btn-info">
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