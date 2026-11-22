<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
</head>
<body>

<?php
if(isset($_GET['new_deposit_btn'])){

$user = $_GET['userId'];

}?>

<form action="sent.php">
    <div class="wrap">

        <div class="rol">

                <!-- userId -->
                    <div class="wrap-inp">
                    <label for="">User Id</label>
                    <input type="email" value="<?= htmlspecialchars($user) ?>" disabled>
                    <input type="hidden" name="userId" value="<?= htmlspecialchars($user) ?>" >
                    </div>

                <!-- sender name -->
                    <div class="wrap-inp">
                    <label for="">Sender Name</label>
                    <input type="text" title="Sender Name" name="sender_name" require>
                    </div>
        </div>

        <div class="rol">

                    <div class="wrap-inp">
                    <label for="">Transaction Type</label>
                    <select name="transaction_type" id="" require>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                        <option selected value="">Select</option>
                    </select>
                    </div>

                    <div class="wrap-inp">
                        <label for="">Amount</label>
                        <input type="number" placeholder="$0.00" name="amount" require>
                    </div>
        </div>

        <div class="rol">
     <div class="wrap-inp">
     <label for="">Transaction Status</label>
    <select name="t_status" id="" require>
        <option value="Successfully">Successfully</option>
        <option value="Pending">Pending</option>
        <option value="Awaiting">Awaiting</option>
        <option value="Locked">Luck</option>
        <option selected value="">Select</option>
    </select>
     </div>

    <button name="sent_btn">Sent</button>

</div>
    </div>
</form>

<style>
    .wrap{
        display:flex;
       width: 40%;
       background:#f1f1f1;
       padding:10px;
       trasform-translate(-50%, -50%);
       left:30%;
       position:absolute;
       top:20%;
       justify-content:center;
       align-items:space-between;
        flex-direction:column;
        gab:10px;
        .rol{
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            align-items:center;
        }
        div{
            margin:10px;
            display:flex;
            flex-direction:column;
            input{
                border-radius:5px;
                padding:5px;
            }
            select{
                border-radius:5px;
                padding:5px;
            }
        }
        button{
            padding:8px;
            border-radius:10px;
            width: 200px;
            border:none;
            background:#000;
            color:yellow;
        }
    }
</style>




</body>
</html>