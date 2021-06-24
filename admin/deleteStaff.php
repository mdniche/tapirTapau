<?php 
require '../db_conn.php';

global $mysqli;

$id = $_GET['id'];
$sql = "DELETE FROM userdb WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
header('location: staff.php');