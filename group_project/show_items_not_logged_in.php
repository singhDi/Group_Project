<?php
require_once "support.php";
require_once "User_Object.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "support.php";

session_start();
$category = $_SESSION['category'];
$sort_by = $_SESSION['sort_by'];
$number_of_item = $_SESSION['number_of_item'];
$noi="";
if($number_of_item <1){
    $noi = "All";
}else{
    $noi.=$number_of_item;
}
$cstr = "Category : $category , Sorted by : $sort_by , # of items/page : $noi<br>";
$list_of_items = show_all_items($host,$user,$db_password,$database,$item_table,$category,$sort_by,$number_of_item);
$lstr =  $list_of_items;

$process_body="";
$form_body=<<<EOFORM
<form action="buy_items_not_logged_in.php" method="post">
<input type="submit" name="back" value="Back">
</form>
<em>Must login or signup to buy or sell item</em>
EOFORM;

$fstr = ($form_body.$process_body);
$body=$cstr.$lstr.$fstr;
$page = generate_page($body);
echo $page;