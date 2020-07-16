<?php 
$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

if(isset($_POST['userId'])) $userId = $_POST['userId'];

$sql = "SELECT * 
            FROM 
                userinfo
            WHERE 
                user_id = '{$userId}' 
                AND user_deletecheck = '0' 
        ";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    mysqli_free_result($result);
    echo true;
} else {
    mysqli_free_result($result);
    echo false;
}

?>