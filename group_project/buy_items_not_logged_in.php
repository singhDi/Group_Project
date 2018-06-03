<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";

session_start();
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
<form action="{$_SERVER['PHP_SELF']}" method="post">
<em>Category:</em>
<select required name="category_to_pick">$category_options</select>
<em>Sort by:</em>
<select required name="sort_by_to_pick">$sort_by_options</select>
<em>Number of items per Page:</em>
<select required name="num_of_items">$num_of_items</select>
<input type="submit" name="submit_filter" value="Filter">
<br><br>
</form>
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
    $process_filter.= header('Location: show_items_not_logged_in.php');
}
$filter_body = ($filtered_view.$process_filter);
//echo $filter_body;
$buy_item = null;
$list_of_items = show_all_items($host,$user,$db_password,$database,$item_table,"any","any",0);
//echo $list_of_items;

$form_body=<<<EOFORM
<br>
<form action="main.php" method="post">
    <input type="submit" name="back" value="Back">
</form>
<em>Must login or signup to buy or sell item</em>
EOFORM;
//echo $form_body;

$body = $filter_body.$list_of_items.$form_body;
$page = generate_page($body);
echo $page;
