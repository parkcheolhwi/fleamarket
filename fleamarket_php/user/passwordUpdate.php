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
    
    /**
     * 渡されたデータを取得する
     * @var array $passwordUpdateData
     */
    $passwordUpdateData = array(
        'userNo' => mysqli_real_escape_string($conn, $_POST['userNo']),
        'oldPassword' => mysqli_real_escape_string($conn, $_POST['oldPassword']),
        'newPassword1' => mysqli_real_escape_string($conn, $_POST['newPassword1']),
        'newPassword2' => mysqli_real_escape_string($conn, $_POST['newPassword2'])
    );
    
    /**
     * Noに該当するPAsswordを検索
     * @var Ambiguous $sql
     */
    $sql = "
            SELECT user_password 
                FROM
                    userinfo
                WHERE
                    user_no = {$passwordUpdateData['userNo']}
        ";

    /**
     * データがあると代入する
     * @var unknown $result
     */
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
    
    /**
     * 旧パスワードをチェックする
     */
    if ($data['user_password'] == $passwordUpdateData['oldPassword']){
        $sql = "
                UPDATE 
                    userinfo
                    SET 
                        user_password = '{$passwordUpdateData['newPassword2']}'
                    WHERE 
                        user_no = '{$passwordUpdateData['userNo']}'
                ";
        if(!mysqli_query($conn, $sql)){
            $errorMsg = "SQL文実行エラーになりました。";
            $path = "index";
            header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
            exit;
        }
        #セッションを切れてログイン画面にもどる
        session_destroy();
        $successMsg = "パスワードが更新されました。";
        header("Location: ./login.php?successMsg={$successMsg}");
        exit;
    } else{
        $errorMsg = "旧パスワードが間違っています。";
        header("Location: ./detailUser.php?errorMsg={$errorMsg}");
        exit;
    }
    
    
?>