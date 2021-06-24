<?php
require '../session.php';
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
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

// call the register() function if register_btn is clicked
if (isset($_POST['btnRegister'])) {
    register();
}

// REGISTER USER
function register()
{
    // call these variables with the global keyword to make them available in function
    global $mysqli, $errors, $username, $noPhone;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username	= e($_POST['username']);
    $noPhone	= e($_POST['noPhone']);
	$userType	= e($_POST['userType']);
    $password_1	= e($_POST['password_1']);
    $password_2	= e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($noPhone)) {
        array_push($errors, "Phone number is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $userPassword = $password_1;

		$query = "INSERT INTO userdb (username, noPhone, userType, userPassword) 
					VALUES('$username', '$noPhone', '$userType', '$userPassword')";
		mysqli_query($mysqli, $query);
		$_SESSION['success']  = "New user successfully created!!";
		header('location: index.php');
    }
}
?>
<!DOCTYPE html>
<html>
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
    <title>TT</title>
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
	<small>
		<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['userType']); ?>)</i> 
		<br>
	</small>
	
	<ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="staff.php">Staff</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="../logout.php">Logout</a></li>
        <li><a class="active" href="create_user.php">Create User</a></li>
	</ul><br><br>

	<?php echo display_error(); ?>
	<center>
		<form method="post" action="create_user.php">
			<table border="1">
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" placeholder="Ex: masbruno" value="<?php echo $username; ?>"></td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td><input type="text" name="noPhone" placeholder="Ex: 0123456789" value="<?php echo $noPhone; ?>"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password_1"></td>
				</tr>
				<tr>
					<td>Confirm Password</td>
					<td><input type="password" name="password_2"></td>
				</tr>
				<tr>
					<td>User Type</td>
					<td><select name="userType">
							<option value="">Select user type</option>
							<option value="admin">Administrator</option>
							<option value="staff">Staff</option>
						</select>
					</td>
				</tr>
				<tr>
					<th colspan="2"><button type="submit" name="btnRegister">Register</button></th>
				</tr>
			</table>
		</form>
	</center>
	<?php endif ?>
</body>
</html>