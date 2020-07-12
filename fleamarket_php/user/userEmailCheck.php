<?php 
require_once '../db/connection.php';


if(isset($_POST['userEmail'])) $userEmail = $_POST['userEmail'];

$sql = "SELECT * FROM userinfo ";
$sql .= " WHERE user_email = '{$userEmail}' AND user_deletecheck = '0'";

$result = connection($sql);

if (mysqli_num_rows($result) > 0) {
    echo true;
} else {
    echo false;
}

?>