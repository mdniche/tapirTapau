<?php 
require '../db_conn.php';

global $mysqli;

$id = $_GET['id'];
$sql = "UPDATE userdb SET userPassword = ?, noPhone = ?, userType = ? WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
header('location: staff.php');