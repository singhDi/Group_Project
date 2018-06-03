<?php
require_once "support.php";
session_start();
$order_body=<<<EOORDER
    <div class="container ">
            <div class="bodyBackground pb-4 pt-3">
                <h4 class="text-center green mb-4 ">Processing Order</h4>
               
				<form class="mt-4" action="finalize_order.php" method="post">
					<div class="container">
                        <div class="row">
                            <div  class="col-md-4">
                            </div>
                            <div class="col-md-4">
								<input type="text" name="item_ids" placeholder="45,55,76" pattern="([0-9]*(\,))*([0-9]*" class="form-control" autofocus required>
                                <input type="submit" name="order" class="form-control btn btn-lg btn-info" value="Review Order">
							</div>
                            <div  class="col-md-4">
                            </div>
                        </div>
                        <div>
                            
								<div align="center" class="mt-3 ">
                                    <a class="text-success " href="logged_in_main.php">Cancel</a>
                                </div>
							
						</div>
					</div>

				</form>
			</div>
			<footer id="footer" class=" p-3 footercolor">

                Made By: Kevin Chen  || Olivier Toujas || Dipisha Singh || Pradeep Sharma
            </footer>


		</div>
EOORDER;

$body = $order_body;
$page=generate_page($body);
echo $page;