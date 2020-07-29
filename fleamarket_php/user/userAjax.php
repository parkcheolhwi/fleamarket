<?php use PHPMailer\PHPMailer\PHPMailer;?>
<?php 
session_start();
require_once '../db/connection.php';
require_once './user.inc';
$model = new UserModel();
$model -> getForm();

switch($model->getUserCmd()){
    case 'idCheck':             #会員登録する際IDの重複チェック
        idCheck();
        break;
    case 'emailCheck':          #会員登録する際E-メールの重複チェック
        emailCheck();
        break;
    case 'likeCount':           #他のユーザーの評価
        likeCount();
        break;
    case 'hateCount':           #他のユーザーの評価
        hateCount();
        break;
    case 'goodsCountCheck':     #ユーザーが登録した出品項目チェック
        goodsCountCheck();
        break;
    case 'findId':              #ユーザーID探す
        findId();
        break;
    case 'findPassword':        #ユーザーパスワード探す
        findPassword();
        break;
    case 'certificationNumberCheck':        #パスワード探すで認証番号チェック
        certificationNumberCheck();
        break;
    case 'newPassword':         #パスワード探し後新しいパスワード設定                              
        newPassword();
        break;
    case 'deleteUser':          #会員脱退
        deleteUser();
        break;
    case 'userModal':           #ユーザー詳細MODAL表示
        userModal();
        break;
    case 'insertUserCheck':     #会員登録してメールから認証を行う
        insertUserCheck();
        break;
    case 'updateUser':          #ユーザー情報更新              
        updateUser();
        break;
    case 'updatePassword':      #ユーザーパスワード更新
        updatePassword();
        break;
    case 'login':               #ログイン
        login();
        break;
    case 'signup':              #会員登録                  
        signup();
        break;
}
function signup(){
    global $model;


    $userMailCheck = mt_rand(100000, 999999);

    #ID, EMAILチェック
    $sql = " SELECT * FROM userinfo WHERE  (user_id = '{$model->getUserId()}' OR user_email = '{$model->getUserEmail()}') AND user_deletecheck = '0'  ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo "99";
        return;
    }
    
    # 実行するSQL文
    $sql = " INSERT INTO userinfo
            (
            user_no,
            user_id,
            user_password,
            user_name,
            user_birth,
            user_phone,
            user_email,
            user_zipcode,
            user_address1,
            user_address2,
            user_createdate,
            user_mailcheck
            )
            VALUES
            (
            NULL,
            '{$model->getUserId()}',
            '{$model->getUserPassword()}',
            '{$model->getUserName()}',
            '{$model->getUserBirth()}',
            '{$model->getUserPhoneNumber()}',
            '{$model->getUserEmail()}',
            '{$model->getUserZipcode()}',
            '{$model->getUserAddress1()}',
            '{$model->getUserAddress2()}',
            NOW(),
            '{$userMailCheck}'
            )";
    
    connection($sql);
    
    /**
     * メール送信
     */
    $mailTitle = "会員登録しました。";
    $mailContent = "<html><body>{$model->getUserId()}様。<br><br>";
    $mailContent .= "会員登録ありがとうございます。<br> 以下のURLで認証を行ってください。<br><br>";
    $mailContent .= "<a href='http://localhost:8712/fleamarket_parkcheolhwi/user/userAjax.php?userId={$model->getUserId()}&num={$userMailCheck}&userCmd=insertUserCheck'>認証する</a>";
    
    require_once '../PHPMail/PHPMailer.php';
    require_once '../PHPMail/SMTP.php';
    require_once '../PHPMail/Exception.php';
    
    $mail = new PHPMailer();
    
    #smtp setting
    $mail -> isSMTP();
    $mail -> Host= "smtp.gmail.com";
    $mail -> SMTPAuth = true;
    $mail -> Username = "parktest9999@gmail.com";
    $mail -> Password = "srlsl8183";
    $mail -> Port = 465;
    $mail -> SMTPSecure = "ssl";
    
    #送る先
    $mail ->CharSet = "UTF-8";
    $mail ->isHTML(true);
    $mail ->setFrom("{$model->getUserEmail()}", "{$model->getUserId()}");
    $mail ->addAddress("parktest9999@gmail.com"); #私のemail
    $mail ->Subject = $mailTitle;
    $mail ->Body = $mailContent;
    
    if($mail -> send()){
       echo "1";
       return;
    }
}
function login(){
    global $model;

    $sql = " SELECT  * FROM  userinfo WHERE user_deletecheck = 0  AND user_id = '{$model->getUserId()}'  AND user_password = '{$model->getUserPassword()}' ";
    $result = connection($sql);
    
    if (mysqli_num_rows($result) != 1){
        echo "9";
        return;
    }
    
    $data = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0 && $data['user_mailcheck'] != 'Y') {
        echo "99";
        return;
    }
    

    /* セッション、クッキーに情報の格納しメイン画面に移動する*/
    $_SESSION['userInfo'] = $data;
    
    if($_POST['idSaveCheck'] == 'on'){
        setcookie("userIdLogin", $model->getUserId(), (time() + 30 * 86400), '/');
    }
    if($_POST['passwordSaveCheck'] == 'on'){
        setcookie("userPasswordLogin", $model->getUserPassword(), (time() + 30 * 86400), '/');
    }
    echo "1";    
}
function updatePassword(){
    global $model;
    /**
     * Noに該当するPAsswordを検索
     * @var Ambiguous $sql
     */
    $sql = " SELECT user_password FROM userinfo WHERE user_no = {$model->getUserNo()} ";
    
    /**
     * データがあると代入する
     * @var unknown $result
     */
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
    }
    
    /**
     * 旧パスワードをチェックする
     */
    if ($data['user_password'] == $model->getOldPassword()){
        $sql = " UPDATE userinfo SET user_password = '{$model->getUserPassword()}' WHERE user_no = '{$model->getUserNo()}' ";
        connection($sql);
        
        #セッションを切れてログイン画面にもどる
        session_destroy();
        echo "1";
        return;
    } else{
       echo "9";
       return;
    }
}

function updateUser(){
    global $model;
    #更新するE-メールの重複チェック
    $sql = " SELECT * FROM userinfo WHERE user_email = '{$model->getUserEmail()}' AND user_deletecheck = '0' AND NOT user_no = {$model->getUserNo()} ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result)>0){
        echo "999";
        return;
    }    
    
    #ユーザーがあるかチェック
    $sql = " SELECT * FROM userinfo WHERE user_no = {$model->getUserNo()} ";
    $result = connection($sql);
    
    #ユーザーがあると取得したデータを更新する
    if(mysqli_num_rows($result) > 0){
        $sql = " UPDATE userinfo SET
                    user_phone = '{$model->getUserPhoneNumber()}',
                    user_email = '{$model->getUserEmail()}',
                    user_zipcode = '{$model->getUserZipcode()}',
                    user_address1 = '{$model->getUserAddress1()}',
                    user_address2 = '{$model->getUserAddress2()}',
                    user_updatedate = NOW()
                WHERE user_no = '{$model->getUserNo()}'
        ";
        connection($sql);

        $sql = " SELECT * FROM userinfo WHERE user_no = {$model->getUserNo()} ";
        
        $result = connection($sql);
        
        #更新したらセッションもアップデートする
        $data = mysqli_fetch_assoc($result);
        $_SESSION['userInfo'] = $data;
        echo "1";
    }else{
        session_destroy();
        $errorMsg = "データが存在しません。";
        header("Location: ../login.php?errorMsg={$errorMsg}");
        exit;
    }
}
function insertUserCheck(){
    global $model;
    
    $sql = " SELECT user_mailcheck, user_createdate FROM userinfo WHERE user_id = '{$model->getUserId()}' AND user_deletecheck = '0' ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result) == 0){
        $errorMsg = "データが存在しません。";
        header("Location: ../error.php?errorMsg={$errorMsg}");
        exit;
    }

    $data = mysqli_fetch_assoc($result);
    if($data['user_mailcheck'] == "Y"){
        $errorMsg = "認証が完了しました。ログインしてください。";
        header("Location: ./login.php?errorMsg={$errorMsg}");
        exit;
    }
    
    if($data['user_mailcheck'] == $model->getNum()){
        
        $dateTerm = strtotime(date("Y-m-d H:m:s", time())) - strtotime($data['user_createdate']);
        if(ceil($dateTerm / (60 * 60)) > 24){
            $sql = " DELETE FROM userinfo WHERE user_id = '{$model->getUserId()}' AND user_mailcheck = '{$model->getNum()}' ";
            connection($sql);       
            
            $errorMsg = "認証期間が過ぎました。会員登録をしてください。";
            header("Location: ./login.php?errorMsg={$errorMsg}");
            exit;
            }

        $sql = "UPDATE userinfo SET user_mailcheck = 'Y' WHERE user_id = '{$model->getUserId()}'";
        connection($sql);

        $successMsg ="認証を完了しました。ログインしてください。";
        header("Location: ./login.php?successMsg={$successMsg}");
        exit;
    }
    
}
function newPassword(){
    global $model;
    $sql = " UPDATE userinfo SET user_password = '{$model->getUserPassword()}' WHERE user_id ='{$model->getUserId()}' AND user_deletecheck = '0' ";
    connection($sql) ? print "1" : print "999";
}
function certificationNumberCheck(){
    global $model;
    $_SESSION['num'] == $model->getCertificationNumber() ? print "1" : print "99";
}


function userModal(){
    global $model;
    $sql = " SELECT *, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) AS user_hatecount FROM userinfo a
                    LEFT JOIN like_hate_count b ON a.user_no = b.user_no
                        WHERE a.user_no = {$model->getUserNo()}
                        GROUP BY a.user_no ";
    
    $result = connection($sql);
    $data = mysqli_fetch_assoc($result);
    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    
    echo $jsonData;
}
function deleteUser(){
    global $model;
    
    #ユーザーのパスワードを確認
    $sql = " SELECT user_password FROM userinfo WHERE user_no = {$model->getUserNo()} ";
    $result = connection($sql);

    
    #データがあればパスワードをチェックして一致したら脱退する
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        if($data['user_password'] == $model->getUserPassword()){
            $sql = " UPDATE userinfo SET user_deletedate = NOW(), user_deletecheck = '1' WHERE user_no = {$model->getUserNo()} ";
            
            if(connection($sql)){
                session_destroy();
                echo "1";
            }else{
                echo "999";
            }
            
        }else{
            echo "9";
        }
    }
}

function findPassword(){
    global $model;
    
    $sql = " SELECT user_password FROM userinfo WHERE user_id = '{$model->getUserId()}' AND user_email = '{$model->getUserEmail()}' AND user_deletecheck = '0' ";
    $result = connection($sql);
    if(!$result){
        echo "999";
    }else{
        if(mysqli_num_rows($result) > 0){
            /**
             * メール送信
             */
            $num = mt_rand(1000, 9999);
            $mailTitle = "パスワード探しの認証番号です。";
            $mailContent = "<html><body>{$model->getUserId()}様。<br><br>";
            $mailContent .= "認証番号は　：{$num}　です。<br><br>";
            
            require_once '../PHPMail/PHPMailer.php';
            require_once '../PHPMail/SMTP.php';
            require_once '../PHPMail/Exception.php';
            
            $mail = new PHPMailer();
            
            #smtp setting
            $mail -> isSMTP();
            $mail -> Host= "smtp.gmail.com";
            $mail -> SMTPAuth = true;
            $mail -> Username = "parktest9999@gmail.com";
            $mail -> Password = "srlsl8183";
            $mail -> Port = 465;
            $mail -> SMTPSecure = "ssl";
            
            #送る先
            $mail ->CharSet = "UTF-8";
            $mail ->isHTML(true);
            $mail ->setFrom("{$model->getUserEmail()}", "{$model->getUserId()}");
            $mail ->addAddress("parktest9999@gmail.com"); #私のemail
            $mail ->Subject = $mailTitle;
            $mail ->Body = $mailContent;
            
            if($mail -> send()){
                $_SESSION['num'] = $num;
                echo "1";
            }
        }else{
            echo "9";
        }
        
    }
}
function findId(){
    global $model;
    
    # メールを確認して一致するIDを表示する
    $sql = " SELECT user_id FROM userinfo WHERE user_email = '{$model->getUserEmail()}' AND user_deletecheck = '0' ";
    
    $result = connection($sql);
    
    $data = mysqli_fetch_assoc($result);
    
    echo $data['user_id'];
    
}

function goodsCountCheck(){
    global $model;
    
    $sql = " SELECT userinfo.* , goods.*, goods_file.goods_filerealname FROM userinfo
                    INNER JOIN goods ON userinfo.user_no = goods.user_no
                    LEFT JOIN goods_file ON goods.goods_no = goods_file.goods_no                    
                        WHERE userinfo.user_no = {$model->getUserNo()}
                        GROUP BY goods.goods_no
                        ORDER BY goods.goods_createdate DESC ";
    
    #データを格納しJSONタイプでリターンする
    $result = connection($sql);
    $data = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
    }else{
        echo "9";
        return;
    }

    header('Content-Type: application/json; charset=utf8');
    $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $jsonData;
}

function hateCount(){
    global $model;
    if(!isset($_SESSION['userInfo'])){
        echo "8";
        return;
    }
    
    $sql = " SELECT user_likecount FROM like_hate_count WHERE user_no = {$model->getUserNo()} AND user_hatecount = {$_SESSION['userInfo']['user_no']} ";
    
    $result = connection($sql);
    if(mysqli_num_rows($result) > 0){
        echo '9';
        return;
    }else{
        $sql =" INSERT INTO like_hate_count(lhcount, user_no, user_hatecount) VALUES(NULL, {$model->getUserNo()}, {$_SESSION['userInfo']['user_no']}) ";
                    
        if(connection($sql)){
            $sql = " SELECT a.user_no, a.user_id, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) as user_hatecount FROM userinfo a
                            LEFT JOIN like_hate_count b ON a.user_no = b.user_no 
                                WHERE a.user_no = {$model->getUserNo()}
                                GROUP BY a.user_no";
            $result = connection($sql);
            $data = array();
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $data[] = $row;
                }
            }

            header('Content-Type: application/json; charset=utf8');
            $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $jsonData;
        }
    }
}

function likeCount(){
    global $model;
    if(!isset($_SESSION['userInfo'])){
        echo "8";
        return;
    }
    
    $sql = " SELECT user_likecount FROM like_hate_count WHERE user_no = {$model->getUserNo()} AND user_likecount = {$_SESSION['userInfo']['user_no']} ";
    
    $result = connection($sql);
    if (mysqli_num_rows($result) > 0){
        echo "9";
        return;
    }else{
        $sql =" INSERT INTO like_hate_count(lhcount, user_no, user_likecount) VALUES(NULL, {$model->getUserNo()}, {$_SESSION['userInfo']['user_no']}) ";
                    
        /**
         * count関数でいいね、悪い評価のカウンター数を取得
         */
        if(connection($sql)){
            $sql = " SELECT a.user_no, a.user_id, count(b.user_likecount) AS user_likecount, count(b.user_hatecount) as user_hatecount FROM userinfo a
                            LEFT JOIN like_hate_count b ON a.user_no = b.user_no
                                WHERE a.user_no = {$model->getUserNo()}
                                GROUP BY a.user_no ";
            $result = connection($sql);
            
            $data = array();
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $data[] = $row;
                }
            }
    
            header('Content-Type: application/json; charset=utf8');
            $jsonData = json_encode(array("result"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $jsonData;
        }
    
    }
}
function emailCheck(){
    global $model;
    
    $sql = "SELECT * FROM userinfo WHERE user_email = '{$model->getUserEmail()}' AND user_deletecheck = '0'";
    
    $result = connection($sql);
    mysqli_num_rows($result) > 0 ? print true : print false;
}

function idCheck(){
    global $model;
    
    $sql = " SELECT * FROM userinfo WHERE user_id = '{$model->getUserId()}' AND user_deletecheck = '0' ";
    $result = connection($sql);
    mysqli_num_rows($result) > 0 ? print true : print false;
}


?>