<?php
require_once "support.php";
require_once "db_process.php";
require_once "db_login.php";
require_once "User_Object.php";

session_start();
$seller_email = $_SESSION['seller_email'];
$seller_password = $_SESSION['old_password'];
$process_filter="";
$items_to_show = show_all_items_for_seller($host,$user,$db_password,$database,$item_table,"any",
    "any",0,$_SESSION['seller_email']);
$form_body = <<<EOFORM
<footer id="footer" >
    <form action="logged_in_main.php" method="post">
    <input type="submit" value="Back">
    </form>
</footer>
EOFORM;
$body="<div>".$items_to_show."</div>".$form_body;
$page = generate_page($body);
echo $page;