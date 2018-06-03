<?php
require_once "support.php";
require_once "User_Object.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "support.php";

session_start();
$seller_email = $_SESSION['seller_email'];
$old_password = $_SESSION['old_password'];

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
$list_of_items = show_all_items_for_buyer($host,$user,$db_password,$database,$item_table,$category,$sort_by,$number_of_item);
$lstr =  $list_of_items;

$process_body="";
$form_body=<<<EOFORM
<form action="buy_items.php" method="post">
<input type="submit" name="back" value="Back">
</form>
EOFORM;

if(isset($_POST['back'])){
    $process_filter.= header('Location: buy_items.php');
}
$fstr = ($form_body.$process_body);
$body=$cstr.$lstr.$fstr;
$page = generate_page($body);
echo $page;