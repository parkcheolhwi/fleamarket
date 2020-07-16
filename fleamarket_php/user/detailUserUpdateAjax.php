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

$userDetailUpdateData = array(
    'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
    'userPhoneNumber' => mysqli_real_escape_string($conn, $_POST['userPhoneNumber']),
    'userEmail' => mysqli_real_escape_string($conn, $_POST['userEmail']),
    'userZipCode' => mysqli_real_escape_string($conn, $_POST['userZipCode']),
    'userAddress1' => mysqli_real_escape_string($conn, $_POST['userAddress1']),
    'userAddress2' => mysqli_real_escape_string($conn, $_POST['userAddress2'])
);

$sql = "
        SELECT
             *
            FROM
                userinfo
            WHERE user_no = {$userDetailUpdateData['userNo']}
       
    ";

$result = mysqli_query($conn, $sql);
if(!$result){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

if(mysqli_num_rows($result) > 0){
    mysqli_free_result($result);
    $sql = "
            UPDATE 
                userinfo
                SET 
                    user_phone = '{$userDetailUpdateData['userPhoneNumber']}',
                    user_email = '{$userDetailUpdateData['userEmail']}',
                    user_zipcode = '{$userDetailUpdateData['userZipCode']}',
                    user_address1 = '{$userDetailUpdateData['userAddress1']}',
                    user_address2 = '{$userDetailUpdateData['userAddress2']}',
                    user_updatedate = NOW()
                WHERE user_no = '{$userDetailUpdateData['userNo']}'

        ";
    
    if(!mysqli_query($conn, $sql)){
        $errorMsg = "SQL実行に失敗しました。";
        $path = "index";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
        exit;
    }
    $sql = "
        SELECT
             *
            FROM
                userinfo
            WHERE user_no = {$userDetailUpdateData['userNo']}
            ";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
        $errorMsg = "SQL実行に失敗しました。";
        $path = "index";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
        exit;
    }
    
    $data = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $_SESSION['userInfo'] = $data;
    echo true;
}else{
    session_destroy();
    $errorMsg = "データが存在しません。";
    header("Location: ../login.php?errorMsg={$errorMsg}");
    exit;
}
?>