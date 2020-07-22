<?php 
session_start();

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

$deleteUserData = array(
    'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
    'userPassword' => mysqli_real_escape_string($conn, $_POST['userPassword'])
);

$sql = "
        SELECT 
            user_password
            FROM 
                userinfo
            WHERE 
                user_no = {$deleteUserData['userNo']}
        ";

$result = mysqli_query($conn, $sql);
if(!$result){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    
    if($data['user_password'] == $deleteUserData['userPassword']){
        $sql = "
                UPDATE
                    userinfo
                    SET
                        user_deletedate = NOW(),
                        user_deletecheck = '1'
                    WHERE 
                        user_no = {$deleteUserData['userNo']}
            ";
        
        if(mysqli_query($conn, $sql)){
            session_destroy();
            echo "1";
        }else{
           echo "999";
        }
        
    }else{
        echo "9";
    }
}
?>