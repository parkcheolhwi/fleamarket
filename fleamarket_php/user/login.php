<?php 
session_start();
if(isset($_POST['login'])){
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
     * POSTで渡されたデータ
     * @var array $loginData
     */
    $loginData = array(
        'userId' => mysqli_real_escape_string($conn, $_POST['userId']),
        'userPassword' => mysqli_real_escape_string($conn, $_POST['userPassword'])
    );
    
    /**
     * 実行するSQL文
     * @var Ambiguous $sql
     */
    $sql = "
            SELECT 
                user_mailcheck, user_authority , user_id
                FROM 
                    userinfo
                WHERE
                    user_deletecheck = 0 
                    AND user_id = '{$loginData['userId']}' 
                    AND user_password = '{$loginData['userPassword']}'
            ";
    
    /**
     * SQLエラー
     * @var unknown $result
     */
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $errorMsg = "SQL実行に失敗しました。";
        $path = "index";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
        exit;
    }
    
    /**
     * ログイン結果
     * @var unknown $data
     */
    
    if (mysqli_num_rows($result) != 1) {
        $errorMsg = "ログイン情報がありません。";
        header("Location: ./login.php?errorMsg={$errorMsg}");
        exit;
    } 
    $data = mysqli_fetch_assoc($result);
    
    if($data['user_mailcheck'] != 'Y'){
        $errorMsg = "メール認証をしてください。";
        header("Location: ./login.php?errorMsg={$errorMsg}");
        exit;
        
    } 
    
    /* セッション、クッキーに情報の格納しメイン画面に移動する*/
    $_SESSION['userInfo'] = $data;
    
    if($_POST['idSaveCheck'] == 'on'){
        setcookie("userId", $loginData['userId'], (time() + 30 * 86400), '/');            
    }
    if($_POST['passwordSaveCheck'] == 'on'){
        setcookie("userPassword", $loginData['userPassword'], (time() + 30 * 86400), '/');            
    }
    header("Location: ../index.php");
    exit;
    mysqli_free_result($result);
    mysqli_close($conn);
    
    
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ログイン | フリマシステム</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/user.css">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<?php require_once '../menu/menunav.php';?>
	
	<div class="row">
    	<div class="col-lg-4"></div>	
    		
    	<div class="col-lg-4 login-form">
    		<h3 style="text-align:center">ログイン</h3>
    		<form  action="./login.php" method="post" onsubmit="return loginCheck();">
    			<div class="form-group">
    				<input type="text" class="form-control" id="userId" name="userId" placeholder="IDを入力してください。" value="<?php if(isset($_COOKIE['userId'])) echo $_COOKIE['userId']?>">
    			</div>
    			<div class="form-group">
    				<input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="パスワードを入力してください。" value="<?php if(isset($_COOKIE['userPassword'])) echo $_COOKIE['userPassword']?>">
    			</div>
    			<div>
					<input type="checkbox"  name="idSaveCheck" <?php if(isset($_COOKIE['userId'])) echo "checked"?>>ID保存
					<input type="checkbox"  name="passwordSaveCheck" <?php if(isset($_COOKIE['userPassword'])) echo "checked"?>>PASSWORD保存
				</div>
    			<div class="form-group">
    				<button type="submit" name="login" class="btn btn-primary form-control">ログイン</button>
    			</div>
    			
    			<div class="form-inline">
        			<button type="button" class="btn btn-light form-control col-sm-6" data-toggle="modal" data-target="#findUserId">ID探す</button>
        			<button type="button" class="btn btn-light form-control col-sm-6" data-toggle="modal" data-target="#findUserPassword">PASSWORD探す</button>
    			</div>
    			
    			
    			<!-- Google, FaceBook, ログイン -->
				<div class="btn-group form-group">
					<a class='btn btn-default disabled'><i class="fa fa-google-plus" style="width:16px; height:20px"></i></a>
					<a class='btn btn-default' href='' style="width:12em;"> Sign in with Google</a>
				</div>
				<div class="btn-group form-group">
					<a class='btn btn-primary disabled'><i class="fa fa-facebook" style="width:16px; height:20px"></i></a>
					<a class='btn btn-primary ' href='' style="width:12em"> Sign in with Facebook</a>
				</div>	
				<div class="btn-group form-group">
					<a class='btn btn-info disabled'><i class="fa fa-twitter" style="width:16px; height:20px"></i></a>
					<a class='btn btn-info ' href='' style="width:12em"> Sign in with Twitter</a>
				</div>	
        	</form>	
    	</div>
    	<div class="col-lg-5"></div>
	</div>
	
	<!--ID探すMODAL -->
	<div class="modal" id="findUserId">
		<div class="modal-dialog">
			<div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ID探す</h4>
                    <button type="button" class="close passwordUpdateModalClose" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">	
                	<p class="text-info">登録したE-メールを入力してください。</p>
               		<div class="form-inline" style="margin-bottom: 10px;">
               			E-メール：&nbsp;<input type="email" id="findIdEmail" name="findIdEmail" class="form-control col-sm-9">
               		</div>
               	    <span id="findUserIdResult" class="text-primary"></span>
                </div>
    
                <!-- Modal footer -->
                <div class="modal-footer">
                	<button type="button" class="btn btn-primary" onclick="findUserIdAjax()">探す</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
			</div>
		</div>
	</div>
	
	<!--パスワード探すMODAL -->
	<div class="modal" id="findUserPassword">
		<div class="modal-dialog">
			<div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">パスワード探す</h4>
                    <button type="button" class="close passwordUpdateModalClose" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                	<p class="text-info">登録したIDとE-メールを入力してください。</p>
               		<div class="form-inline" style="margin-bottom: 10px;">
               			ID：&nbsp;<input type="text" id="findPasswordId" name="findPasswordId" class="form-control col-sm-10">
               		</div>
               		<div class="form-inline" style="margin-bottom: 10px;">
               			E-メール：&nbsp;<input type="email" id="findPasswordEmail" name="findPasswordEmail" class="form-control col-sm-9">
               		</div>
               		<span id="findUserPasswordResult" class="text-primary"></span>
                </div>
    
                <!-- Modal footer -->
                <div class="modal-footer">
                	<button type="submit" class="btn btn-primary" onclick="findUserPasswordAjax()">探す</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
			</div>
		</div>
	</div>
	

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="../js/user.js"></script>​
</body>
</html>