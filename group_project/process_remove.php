<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";

session_start();

$item_id = $_POST['item_id'];
$item_info = delete_item_from_database($host,$user,$db_password,$database,$item_table,$item_id);
$body = "The item you just deleted is : <br>".$item_info;
$form_body = <<<EOFORM
<form action="logged_in_main.php" method="post">
<input type="submit" name="back" value="Back">
</form>
EOFORM;

$page = generate_page($body.$form_body);
echo $page;
