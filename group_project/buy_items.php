<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";

session_start();
$seller_email = $_SESSION['seller_email'];$seller_password = $_SESSION['old_password'];
$process_filter="";
$category_options=" <option>Cloths</option>
    <option>Shoes</option>
    <option>Accessories</option>
    <option>Any</option>";
$sort_by_options="<option>Price</option>
                  <option>Popular</option>
                  <option>Any</option>";
$num_of_items = "<option>All</option>
                <option>10</option>
                <option>20</option>";
$filtered_view=<<<EOFILTER
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
<div class="container">
    <div class="bodyBackground pb-4 pt-3">
        <h4 class="text-center green mb-4 ">Welcome to Buying Portal</h4>
			<form class="mt-4" action="{$_SERVER['PHP_SELF']}" method="post">
				<div class="container">
                    <div class="row">
                        <div  class="col-md-2">
                        </div>
                            <div class="col-md-3">
								<label  class="font-weight-bold">Category </label><select required name="category_to_pick">$category_options</select>
							</div>
							<div class="col-md-3">
								<label  class="font-weight-bold">Sort by </label><select required name="sort_by_to_pick">$sort_by_options</select>
							</div>
							<div class="col-md-3">
								<label  class="font-weight-bold">Num of Items per page </label>
								<select required name="num_of_items">$num_of_items</select>
							</div>
							
							
					</div>
					<div class="mt-4">
						<div align="center">
								<input type="submit" name="submit_filter" value="Filter" class="btn btn-lg btn-info" >
								
								<div align="center" class="mt-3 ">
                                    <a class="text-success " href="logged_in_main.php">Back</a>
                                </div>
							</div>
							</div>
					</div>
				</div>
							
			</form>
	</div>
</div>
EOFILTER;
if(isset($_POST['submit_filter'])){
    $category=strtolower($_POST['category_to_pick']);
    $sort_by = strtolower($_POST['sort_by_to_pick']);
    $number_of_item = $_POST['num_of_items'];
    if($number_of_item === "All"){
        $number_of_item = 0;
    }else{
        $number_of_item = (int) $number_of_item;
    }
    if($sort_by === "popular"){
        $sort_by = "visited";
    }
    $_SESSION['category'] = $category;
    $_SESSION['sort_by'] = $sort_by;
    $_SESSION['number_of_item'] = $number_of_item;
    $process_filter.= header('Location: show_items.php');
}
 $filter_body = ($filtered_view.$process_filter);
//echo $filter_body;
$buy_item = null;
$list_of_items = show_all_items_for_buyer($host,$user,$db_password,$database,$item_table,"any","any",0);
//echo $list_of_items;

//echo $form_body;

$body = $filter_body.$list_of_items;
//$body = $filter_body.$form_body;

$page = generate_page($body);
echo $page;
?>