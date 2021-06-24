<?php
require '../session.php';
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (!isAdmin()) {
    $_SESSION['msg'] = "Access denied";
    
    if (isStaff()) {
        header('location: ../staff/index.php');
    } elseif (isCustomer()) {
        header('location: ../customer/index.php');
    } else {
        header('location: ../login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table {
            border: black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css"/>
    <title>TapirTapau</title>
</head>
<body>
    <center>
        <table>
            <tr>
                <th><img src="../img/tapir_logo.png" width="25%"/></th>
            </tr>
            <tr>
                <th><h3>TapirTapau(TT)</h3></th>
            </tr>
        </table>
    </center>

    <?php if (isset($_SESSION['user'])) : ?>
    <strong><?php echo $_SESSION['user']['username']; ?></strong>
    
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="staff.php">Staff</a></li>
        <li><a class="active" href="orders.php">Orders</a></li>
        <li><a href="../logout.php">Logout</a></li>
        <li><a href="create_user.php">Create User</a></li>
    </ul><br><br>

    <center>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Food</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            
            <?php
            $sql = "SELECT * FROM orderdb";
            if ($result = $mysqli->query($sql)) {
                while ($row = $result->fetch_array()) {
            ?>
            
            <tr>
                <th><?php echo $row['idOrder']; ?></th>
                <th><?php echo $row['nameFood']; ?></th>
                <th><?php echo $row['quantityFood']; ?></th>
                <th><?php echo $row['totalPrice']; ?></th>
            </tr>

            <?php
                }
            }
            ?>
        </table>
    </center>
    <?php endif ?>
</body>
</html>