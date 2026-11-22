<?php
require_once '../db_config.php';

if(isset($_GET['sent_btn'])){

        $user_id = $_GET['userId'];
        $sender_name = $_GET['sender_name'];
        $type = $_GET['transaction_type'];
        $amount = $_GET['amount'];
        $t_status = $_GET['t_status'];

        $sql = $conn->query("INSERT INTO
                            transaction_history(user_id,sender_name,transaction_type,amount,t_status)
                            VALUES('$user_id','$sender_name','$type','$amount','$t_status')"
                            );

       if($sql){
        echo "transaction successfully";
        echo $user_id;
        echo $sender_name;
        echo $type;
        echo $amount;
        echo $t_status;
       }else{
        echo $conn->error;
       }            
}




?>