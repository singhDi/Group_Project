<?php
require_once "db_login.php";
require_once "db_process.php";
require_once "support.php";
session_start();


$arr_of_id = array($_POST['item_id']);
$_SESSION['arr_of_id'] = $arr_of_id;
$review = review_items($host,$user,$db_password,$database,$item_table,$arr_of_id);
$total_cost = $review["totalCost"];
$list_of_items = $review["itemsList"];
$review_string = "";

$cancel_body_logged_in=<<<EOFORM
<br>
<div align="center">
<form action="logged_in_main.php" method="post">
    <input type="submit" name="back" value="Cancel">
</form>
</div>
EOFORM;
$cancel_body_not_logged_in=<<<EOFORM
<br>
<form action="main.php" method="post">
    <input type="submit" name="back" value="Cancel">
</form>
EOFORM;
$card_info=<<<EOCARD
    <div class="container ">
            <div class="bodyBackground pb-4 pt-3">
                <h4 class="text-center green mb-4 ">Your Order</h4>
               
				<form class="mt-4" action="final_page.php" method="post">
					<div class="container">
                        <div class="row">
                            <div  class="col-md-2">
                            </div>
                            <div class="col-md-2">
								<b>Card Type : </b><input type="text" name="card_type" placeholder="VISA" autofocus required><br><br>
                                <b>Card Number : </b><input type="text" name="card_num" autofocus required><br><br>
                                <b>Name on Card :</b><input type="text" name="name" placeholder="firstname lastname" required><br><br>
                                <b>CVV/CVC number : </b><input type="text" name="security_num" pattern="[0-9]*" required><br><br>
                                <b>Exp Date : </b><input type="text" name="exp" pattern="[0-9]{2}(\/)[0-9]{2}" placeholder="11/20" required><br><br>
							</div>
                            <div  class="col-md-2">
                            </div>
                            <div  class="col-md-2">
                                    $list_of_items<br>
                                    <b>Total Cost : </b> $total_cost<br>
                            </div>
                        </div>
                        <div>
                            <div align="center">
								<div align="center" class="mt-3 ">
                                    <form action="final_page.php" method="post">
                                        <input type="submit" name="complete_order" value="Pay"><br><br>
                                    </form>
                                </div>
							</div>
						</div>
					</div>

				</form>
			</div>
			<footer id="footer" class=" p-3 footercolor">

                Made By: Kevin Chen  || Olivier Toujas || Dipisha Singh || Pradeep Sharma
            </footer>
		</div>
EOCARD;
if($_SESSION['seller_email'] === "" && $_SESSION['old_password']===""){
    $body = $review_string.$card_info.$cancel_body_not_logged_in;
}else{
    $body = $review_string.$card_info.$cancel_body_logged_in;
}

$page=generate_page($body);
echo $page;