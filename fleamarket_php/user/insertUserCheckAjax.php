
<?php
/**
 * メールから認証を行って最終的に会員登録をする
 */


if(isset($_GET['num'])) $num = $_GET['num'];
if(isset($_GET['userId'])) $userId = $_GET['userId'];

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

$sql = "
    SELECT 
        user_mailcheck, user_createdate
        FROM 
            userinfo 
        WHERE 
            user_id = '{$userId}'
            AND user_deletecheck = '0'
            
";


/**
 * SQLQuery実行確認
 */
$result = mysqli_query($conn, $sql);
if(!$result){
    $errorMsg = "SQL実行に失敗しました。";
    $path = "index";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

if(mysqli_num_rows($result) == 0){
    $errorMsg = "データが存在しません。";
    header("Location: ../error.php?errorMsg={$errorMsg}");
    exit;
}

/**
 * 認証番号が等しければ処理する
 * @var unknown $data
 */
$data = mysqli_fetch_assoc($result);
mysqli_free_result($result);
if($data['user_mailcheck'] == "Y"){
    $errorMsg = "認証が完了しました。ログインしてください。";
    header("Location: ./login.php?errorMsg={$errorMsg}");
    exit;
}

if($data['user_mailcheck'] == $num){
    
    /**
     * 認証期間が過ぎたか確認する
     */
    $dateTerm = strtotime(date("Y-m-d H:m:s", time())) - strtotime($data['user_createdate']);
    if(ceil($dateTerm / (60 * 60)) > 24){
        $sql = "
                DELETE FROM userinfo
                    WHERE user_id = '{$userId}' AND user_mailcheck = '{$num}';
                ";
        
        if(!mysqli_query($conn, $sql)){
            $errorMsg = "SQL実行に失敗しました。";
            $path = "index";
            header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
            exit;
        }
        
        $errorMsg = "認証期間が過ぎました。会員登録をしてください。";
        header("Location: ./login.php?errorMsg={$errorMsg}");
        exit;
    }    
    
    /**
     * 認証ができたらuser_mailcheckをYで変更する
     */
    #認証ができたらuser_mailcheck を Y で更新する
    $sql = "UPDATE userinfo SET user_mailcheck = 'Y' WHERE user_id = '{$userId}'";
    if(!mysqli_query($conn, $sql)){
        $errorMsg = "SQL実行に失敗しました。";
        $path = "index";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
        exit;
    }
    
    /**
     * ログインページに戻る
     * @var string $successMsg
     */
    mysqli_close($conn);
    $successMsg ="認証を完了しました。ログインしてください。";
    header("Location: ./login.php?successMsg={$successMsg}");
    exit;
}


?>