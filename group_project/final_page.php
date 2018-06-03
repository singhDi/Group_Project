<?php
require_once "support.php";
require_once "db_login.php";
require_once "db_process.php";
session_start();
$arr_of_id = $_SESSION['arr_of_id'];
increment_visited($host,$user,$db_password,$database,$item_table,$arr_of_id);
$body = <<<EOSTR
<div align="center">
<h3>Thank you for shopping with us.</h3><br><br>
<form action="logged_in_main.php" method="post">
<input type="submit" value="To Main Page">
</form>
</div>
EOSTR;
$page=generate_page($body);
echo $page;


