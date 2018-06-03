<?php
require_once "support.php";
require_once "db_login.php";
require_once "db_process.php";
session_start();
$seller_email = ($_SESSION['seller_email']);
$old_password = ($_SESSION['old_password']);

$processed_body = "";
if (!isset($_POST['submit']) && !isset($_POST['return_to_main'])){
    $title     = "";
    $brand    = "";
    $price      = (float)0.0;
    $category = "";
    $description = "";
    $link_to_image = "";
}elseif(isset($_POST['submit'])) {
    $title     = trim($_POST['title']);
    $brand    = trim($_POST['brand']);
    $price      = (float)trim($_POST['price']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    if(!isset($_POST['link_to_image']) || trim($_POST['link_to_image']) === ""){
        $link_to_image = "image_not_available.png";
    }else{
        $link_to_image =  trim($_POST['link_to_image']);
    }

    if($title === "") {
        $processed_body .= "please type at least one word for title";
    }elseif($brand === ""){
        $processed_body.="if brand is unknown type unknown";
    }elseif ($price < 0){
        $processed_body.="price cannot have negative value";
    }elseif ($description === ""){
        $processed_body.="describe about your item";
    }else{
        if(strlen($title) > 100){
            $title = substr($title,0,100);
        }
        if(strlen($description) > 250){
            $description = substr($description,0,250);
        }
        add_item_to_database($host,$user,$db_password,$database,$item_table,$title,$brand,$price,$category,$description,$seller_email,$link_to_image);
        $_SESSION['seller_email'] = $seller_email;
        $_SESSION['old_password'] = $old_password;
        $processed_body.= header('Location: logged_in_main.php');
    }
}

$form_body=<<<EOFORM
    <nav class="nav nav-pills red mb-2 p-2">
    <a class=" navbar-brand" href="#">UMD-bay</a>

    <a class="nav-link " href="logged_in_main.php">Home</a>

    <div class="btn-group hover">
    <a class="nav-link dropdown-toggle" id="active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#A8A2A2">
    My Account
    </a>
    <div class="dropdown-menu black bg-info">
    <ul>
    <li><a href="view_profile.php">View Profile</a></li>
    <li><a href="update_profile.php">Update Profile</a></li>
    <li><a href="main.php">Logout</a></li>
    </ul>
    </div>
    </div>
    <a class="nav-link " href="buy_items.php">Buy</a>
    <a class="nav-link " href="submit_item.php">Sell</a>
    </nav>

    <div class="container ">
    <div class="bodyBackground pb-4 pt-3">
    <h4 class="text-center green mb-4 ">Sellers Portal</h4>

    <form class="mt-4" action="{$_SERVER['PHP_SELF']}" method="post">

    <div class="container">
    <div class="row">
    <div  class="col-md-2">
    </div>
    <div class="col-md-4">

    <label class="font-weight-bold">Title</label>
    <input type="text" name="title" value = "$title" class="form-control">

    </div>
    <div class="col-md-4">
    <label  class="font-weight-bold">Brand</label>
    <input type="text" name="brand" value="$brand" class="form-control">

    </div>
    <div  class="col-md-2">
    </div>
    </div>

    <div class="row mt-3">
    <div  class="col-md-2">
    </div>
    <div class="col-md-4">

    <label class="font-weight-bold">Price</label>
    <input type="text" name="price" value = "$price" class="form-control">

    </div>
    </div>	
    <div class="row mt-3">
    <div  class="col-md-2">
    </div>
    <div class="col-md-4">
    <lable for="shipping" class="font-weight-bold">Category</lable>
        <div>
        <div class="form-check form-check-inline pt-2" >
        <input type="radio" name="category" value="cloths">
        <lable for="cloths"> Clothes</lable>
            </div>	
            <div class="form-check form-check-inline pt-2">
            <input type="radio" name="category" value="shoes">
            <lable for="shoes"> Shoes</lable>
                </div
                <div class="form-check form-check-inline pt-2">
                <input type="radio" name="category" value="accessories">
                <lable for="accessories"> Accessories</lable>
                    </div>
                   


                        </div>



                        </div>

                        <div class="row mt-3">
                        <div  class="col-md-2">
                        </div>
                        <div class="col-md-8">
                        <label class="font-weight-bold">Description</label>	
                        <textarea name = "description" rows="5" class="textareaCol"></textarea>

                        </div>

                        <div  class="col-md-">
                        </div>
                        </div>

                        <div class="row mt-3">
                        <div  class="col-md-2">
                        </div>

                        <div class="col-md-4">
                        <label  class="font-weight-bold">Upload Image</label>
                        <input type="text" name="link_to_image" id="fileToUpload" class="pt-1 value="$link_to_image">

						</div>
						<div  class="col-md-2">
						</div>
					</div>
				<div class="mt-4">
					<div align="center">
					<input type="reset" class="btn btn-lg btn-info">
					<input type="submit" name="submit" value="Post Item" class="btn btn-lg btn-info">

				</div>
                <div align="center" class="mt-3 ">
                                    <a class="text-success " href="logged_in_main.php">Back</a>
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