<?php 
$conn = mysqli_connect(
    'localhost',
    'root',
    '123456',
    'fleamarket'
    );

/**
 * DB接続チェックする
 */
if(mysqli_connect_errno()){
    $errorMsg = "DB接続に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

$findUserIdData = array(
  'userEmail' => mysqli_real_escape_string($conn, $_POST['userEmail'])  
);

$sql = "
        SELECT 
            user_id
            FROM
                userinfo
            WHERE 
                user_email = '{$findUserIdData['userEmail']}'
                AND user_deletecheck = '0'
    ";

$result = mysqli_query($conn, $sql);
if(!$result){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

$data = mysqli_fetch_assoc($result);

echo $data['user_id'];
?>