<?php
require_once "User_Object.php";
require_once "Item_Object.php";

function exists($host,$user,$password,$database,$table,$email){
    $data_found = true;
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    $query = <<<EOQUERY
    select * from $table where email='$email';
EOQUERY;
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: ". $db_connection->error);
    } else {
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            $data_found = false;
        } else {
            $data_found = true;
        }
    }
    /* Freeing memory */
    $result->close();
    /* Closing connection */
    $db_connection->close();
    return $data_found;
}

function is_matched($host,$user,$password,$database,$table,$email,$user_password){
    $user_obj = null;
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query = <<<EOQUERY
select * from $table where email='$email';
EOQUERY;

    #select * from $table where email=$email;
    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: ". $db_connection->error);
    } else {
        /* Number of rows found */
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            #if empty do nothing because $arr is empty
        } else {
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if(password_verify($user_password,"{$row['password']}")) {
                    $user_obj = new User_Object("{$row['first_name']}","{$row['middle_name']}","{$row['last_name']}",
                        "{$row['email']}","{$row['phone_number']}","{$row['password']}");
                }
            }
        }
    }
    /* Freeing memory */
    $result->close();
    /* Closing connection */
    $db_connection->close();
    return $user_obj;
}

function add_to_database($host,$user,$password,$database,$table,
                         $first_name,$middle_name,$last_name,$email,$phone_number,
                         $user_password, $docName, $docMimeType, $docData){
    $db_connection = new mysqli($host, $user, $password, $database);

    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query = <<<EOQUERY
insert into $table values('$first_name','$last_name','$middle_name','$email','$phone_number','$user_password', '$docName', '$docMimeType', '$docData');
EOQUERY;
    //  $query = "insert into $table values($name,$email,$gpa,$year,$gender,$password)";

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();

}

function copy_data($host,$user,$password,$database,$table,$from,$to){
    //change the seller name for all items to $to associated with $from
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    $query = <<<EOQUERY
     update $table set seller_email='$to' where seller_email='$from'
EOQUERY;
    $result = $db_connection->query($query);
    if (!$result) {
        die("update of seller for items failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();
    return true;//success
}

function   add_item_to_database($host,$user,$password,$database,$table,
            $title,$brand,$price,$category,$description,$seller_email,$link_to_image){
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query = <<<EOQUERY
insert into $table (title,brand,price,category,description,seller_email,visited,link_to_image)
values('$title','$brand','$price','$category','$description','$seller_email',0,'$link_to_image');
EOQUERY;
    //  $query = "insert into $table values($name,$email,$gpa,$year,$gender,$password)";

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();
}



function update_user($host,$user,$password,$database,$user_table,$email,User_Object $old_user,User_Object $new_user){
    /// update user's information
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
     $new_first_name = $new_user->get_first_name();
     $new_middle_name = $new_user->get_middle_name();
     $new_last_name = $new_user->get_last_name();
     $new_phone = $new_user->get_phone_number();
    $new_password = $new_user->get_password();

    /* Query */
    $query = <<<EOQUERY
     update $user_table set first_name='$new_first_name',middle_name='$new_middle_name',last_name='$new_last_name',phone_number='$new_phone',password='$new_password' where email='$email'
EOQUERY;
    //  $query = "insert into $table values($name,$email,$gpa,$year,$gender,$password)";

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();
}

function  delete_user_from_database($host,$user,$password,$database,$user_table,$seller_email){
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }

    /* Query */
    $query = <<<EOQUERY
    delete from $user_table where email='$seller_email';
EOQUERY;
    //  $query = "insert into $table values($name,$email,$gpa,$year,$gender,$password)";

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();
}

function show_all_items($host,$user,$password,$database,$table,$category,$sort_by,$number_of_item){
    $item_to_buy=null;
    $list_of_items = "";
    if($category === "any"){
        $category_filter = "";
    }else{
        $category_filter = "where category= '$category'";
    }
    if($sort_by === "any"){
        $sort_by_filter = "";
    }else{
        if($sort_by==="price")
        $sort_by_filter = "order by ".$sort_by;
        else{
            $sort_by_filter = "order by ".$sort_by." DESC";
        }
    }
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query="";

        $query .= <<<EOQUERY
select * from $table $category_filter $sort_by_filter;
EOQUERY;

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: ". $db_connection->error);
    } else {
        /* Number of rows found */
        $num_rows = $result->num_rows;

        if ($num_rows === 0) {
           echo "No items for sale";
        } else {
            if($number_of_item < 1){
                for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                    $result->data_seek($row_index);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $item_to_look = "itemid"."{$row['id']}";
                    $item_detail=<<<EODETAIL
                        
<strong>{$row['title']}</strong><br>
<img src={$row['link_to_image']} style="width:200px;height:300px;"><br>
<strong>Brand : {$row['brand']} </strong><em> Price : {$row['price']}</em><br>
<em>{$row['description']}</em><br>
<em>***Item's ID Number : {$row['id']}</em><br><br>
EODETAIL;
    $list_of_items.=$item_detail;;

                }
            }else{
                $row_index = 0;
                $list_of_items = get_next($num_rows,$number_of_item,$row_index,$result);
                if(isset($_POST['next'])){
                    $row_index = $row_index+$number_of_item;
                  $list_of_items =  get_next($num_rows,$number_of_item,$row_index,$result);
                }else if(isset($_POST['prev'])){
                    $row_index = $row_index - $number_of_item;
                    if($row_index < 0){
                        $row_index = 0;
                    }
                 $list_of_items =   get_next($num_rows,$number_of_item,$row_index,$result);
                }

            }
        }
    }
    /* Freeing memory */
    $result->close();
    /* Closing connection */
    $db_connection->close();
    return $list_of_items;
}

function get_next($num_rows,$number_of_item,$row_index,$result){
    $num_of_items = 0;
    $item_to_buy = null;
    $list_of_items = "";
    while ($row_index < $num_rows && $num_of_items < $number_of_item){
        $result->data_seek($row_index);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $item_to_look = "itemid"."{$row['id']}";
        $num_of_items++;
        $row_index++;
        $item_detail=<<<EODETAIL
        <div class="gallery">
                        <img src={$row['link_to_image']}><br>
                        <div class="desc">
                            <strong>{$row['title']}</strong><br>
                            <strong>Brand:</strong> {$row['brand']}<br>
                            <strong>Price</strong>: \${$row['price']}<br>
                            <strong>Description:</strong><br><em>{$row['description']}</em><br>
                            <strong>***Item's ID Number</strong>: {$row['id']}
                            <form action="process_buy.php" method="post">
                                <input type="submit" name="buy" value="Buy Item" class="btn btn-lg btn-info">
                            </form>
                        </div>
        </div>
EODETAIL;
        $list_of_items.=$item_detail;

    }
    $next_button=<<<EONEXT
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="submit" name="next" value="Next"> 
</form>
EONEXT;
    $prev_button=<<<EOPREV
<form action="{$_SERVER['PHP_SELF']}" method="post">
<input type="submit" name="prev" value="Previous"> 
</form>
EOPREV;
    if($row_index < $num_rows)
$list_of_items.=$next_button;
    if($row_index > $number_of_item)
        $list_of_items.= $prev_button;

    return $list_of_items;
}

function review_items($host,$user,$password,$database,$table,$arr_of_id){
    $total_cost = 0.0;
    $items = "";
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    foreach ($arr_of_id as $id) {
        $query = "";

        $query .= <<<EOQUERY
select * from $table where id=$id;
EOQUERY;
        /* Executing query */
        $result = $db_connection->query($query);
        if (!$result) {
            die("Retrieval failed: " . $db_connection->error);
        } else {
            /* Number of rows found */
            $num_rows = $result->num_rows;

            if ($num_rows === 0) {
                $items .= "<b>ID $id is invalid </b><br>";
            } else {
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $item_detail=<<<EODETAIL
<div class="gallery">
                        <img src={$row['link_to_image']}><br>
                        <div class="desc">
                            <strong>{$row['title']}</strong><br>
                            <strong>Brand:</strong> {$row['brand']}<br>
                            <strong>Price</strong>: \${$row['price']}<br>
                            <strong>Description:</strong><br><em>{$row['description']}</em><br>
                        </div>
                    </div>
EODETAIL;
                $items.=$item_detail;
                $total_cost+=(float)($row['price']);

            }

        }
        $result->close();
    }

    /* Freeing memory */
    /* Closing connection */
    $db_connection->close();
    $return_value = array("totalCost"=>$total_cost,"itemsList"=>$items);
    return $return_value;
}
function  increment_visited($host,$user,$password,$database,$table,$arr_of_id)
{

    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    foreach ($arr_of_id as $id) {
        $count=0;
        $query = "";

        $query .= <<<EOQUERY
select * from $table where id=$id;
EOQUERY;
        /* Executing query */
        $result = $db_connection->query($query);
        if (!$result) {
            die("Retrieval failed: " . $db_connection->error);
        } else {
            /* Number of rows found */
            $num_rows = $result->num_rows;
            if ($num_rows === 0) {
                //do nothing
            } else {
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $count = $row['visited'];
            }

        }
        $result->close();
        $count++;
        $query = "";
        $query .= <<<EOQUERY
update $table set visited=$count where id=$id;
EOQUERY;
        $result = $db_connection->query($query);
        if (!$result) {
            die("Retrieval failed: " . $db_connection->error);
        }
    }

    /* Freeing memory */
    /* Closing connection */
    $db_connection->close();
}




function show_all_items_for_buyer($host,$user,$password,$database,$table,$category,$sort_by,$number_of_item){
    $item_to_buy=null;
    $list_of_items = "";
    if($category === "any"){
        $category_filter = "";
    }else{
        $category_filter = "where category= '$category'";
    }
    if($sort_by === "any"){
        $sort_by_filter = "";
    }else{
        if($sort_by==="price")
            $sort_by_filter = "order by ".$sort_by;
        else{
            $sort_by_filter = "order by ".$sort_by." DESC";
        }
    }
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query="";

    $query .= <<<EOQUERY
select * from $table $category_filter $sort_by_filter;
EOQUERY;

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: ". $db_connection->error);
    } else {
        /* Number of rows found */
        $num_rows = $result->num_rows;

        if ($num_rows === 0) {
            echo "No items for sale";
        } else {
            if($number_of_item < 1){
                for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                    $result->data_seek($row_index);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $item_to_look = "itemid"."{$row['id']}";
                    $item_detail=<<<EODETAIL
                    <div class="gallery">
                        <img src={$row['link_to_image']}><br>
                        <div class="desc">
                            <strong>{$row['title']}</strong><br>
                            <strong>Brand:</strong> {$row['brand']}<br>
                            <strong>Price</strong>: \${$row['price']}<br>
                            <strong>Description:</strong><br><em>{$row['description']}</em>
                            <form action="process_buy.php" method="post">
                                <button name="item_id" value="{$row['id']}">Buy Item</button>
                            </form>
                        </div>
                    </div>

EODETAIL;
                    $list_of_items.=$item_detail;;

                }
            }else{
                $row_index = 0;
                $list_of_items = get_next($num_rows,$number_of_item,$row_index,$result);
                if(isset($_POST['next'])){
                    $row_index = $row_index+$number_of_item;
                    $list_of_items =  get_next($num_rows,$number_of_item,$row_index,$result);
                }else if(isset($_POST['prev'])){
                    $row_index = $row_index - $number_of_item;
                    if($row_index < 0){
                        $row_index = 0;
                    }
                    $list_of_items =   get_next($num_rows,$number_of_item,$row_index,$result);
                }

            }
        }
    }
    /* Freeing memory */
    $result->close();
    /* Closing connection */
    $db_connection->close();
    return $list_of_items;
}






function show_all_items_for_seller($host,$user,$password,$database,$table,$category,$sort_by,$number_of_item,$seller){

    $list_of_items = "";
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    /* Query */
    $query="";

    $query .= <<<EOQUERY
select * from $table WHERE seller_email='$seller';
EOQUERY;

    /* Executing query */
    $result = $db_connection->query($query);
    if (!$result) {
        die("Retrieval failed: ". $db_connection->error);
    } else {
        /* Number of rows found */
        $num_rows = $result->num_rows;

        if ($num_rows === 0) {
            echo "No items for sale from this user";
        } else {

                for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                    $result->data_seek($row_index);
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $item_to_look = "itemid"."{$row['id']}";
                    $item_detail=<<<EODETAIL
 <div class="gallery">
                        <img src={$row['link_to_image']}><br>
                        <div class="desc">
                            <strong>{$row['title']}</strong><br>
                            <strong>Brand:</strong> {$row['brand']}<br>
                            <strong>Price</strong>: \${$row['price']}<br>
                            <strong>Description:</strong><br><em>{$row['description']}</em><br>
                            <form action="process_remove.php" method="post">
                                <button name="item_id" value="{$row['id']}">Delete Item</button>
                            </form>
                        </div>
                    </div>
EODETAIL;
                    $list_of_items.=$item_detail;;

                }

        }
    }
    /* Freeing memory */
    $result->close();
    /* Closing connection */
    $db_connection->close();
    return $list_of_items;
}






function  delete_item_from_database($host,$user,$password,$database,$user_table,$item_id){
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        die($db_connection->connect_error);
    }
    $item_to_delete = "";
    /* Query */
    $info_query = <<<EOQUERY
    select * from $user_table where id=$item_id;
EOQUERY;
    $query = <<<EOQUERY
    delete from $user_table where id=$item_id;
EOQUERY;
    //  $query = "insert into $table values($name,$email,$gpa,$year,$gender,$password)";

    /* Executing query */
    $info_result = $db_connection->query($info_query);
    if(!$info_result){
        die("Insertion failed: " . $db_connection->error);
    }else{
        $num_rows = $info_result->num_rows;
        if ($num_rows === 0) {
            echo "No items for sale from this user";
        } else {

            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $info_result->data_seek($row_index);
                $row = $info_result->fetch_array(MYSQLI_ASSOC);
                $item_to_look = "itemid"."{$row['id']}";
                $item_detail=<<<EODETAIL
 <div class="gallery">
                        <img src={$row['link_to_image']}><br>
                        <div class="desc">
                            <strong>{$row['title']}</strong><br>
                            <strong>Brand:</strong> {$row['brand']}<br>
                            <strong>Price</strong>: \${$row['price']}<br>
                            <strong>Description:</strong><br><em>{$row['description']}</em><br>
                            <form action="process_remove.php" method="post">
                                <button name="item_id" value="{$row['id']}">Delete Item</button>
                            </form>
                        </div>
                    </div>
EODETAIL;
                $item_to_delete.=$item_detail;

            }

        }
    }
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    /* Closing connection */
    $db_connection->close();
    return $item_to_delete;
}
?>