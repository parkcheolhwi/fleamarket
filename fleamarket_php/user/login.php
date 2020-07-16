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
               *
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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="../btcss/bootstrap.min.css" rel="stylesheet">
<link href="../btcss/mdb.min.css" rel="stylesheet">
<link href="../btcss/style.css" rel="stylesheet">
<link href="../btcss/addons/datatables2.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/user.css">
</head>
<body>
	<?php require_once '../menu/menunav.php';?>
	
	<div class="row">
    	<div class="col-lg-4"></div>	
    		
    	<div class="col-lg-4 login-form">
    		<h3 style="text-align:center; margin-top:20px;">ログイン</h3>
    		<form  action="./login.php" method="post" onsubmit="return loginCheck();">
    			<div class="md-form">
    				<i class="fas fa-user prefix"></i>
                    <input  type="text" class="form-control" id="userId" name="userId" value="<?php if(isset($_COOKIE['userId'])) echo $_COOKIE['userId']?>">
                    <label for="userId">IDを入力してください。</label>
                </div>
        		<div class="md-form">
        			<i class="fas fa-lock prefix"></i>
                    <input  type="password" class="form-control" id="userPassword" name="userPassword" value="<?php if(isset($_COOKIE['userPassword'])) echo $_COOKIE['userPassword']?>">
                    <label for="userPassword">パスワードを入力してください。</label>
                </div>

				<div class="custom-control custom-checkbox custom-control-inline">
             		   <input type="checkbox" class="custom-control-input" id="idSaveCheck" name="idSaveCheck" <?php if(isset($_COOKIE['userId'])) echo "checked"?>>
                		<label class="custom-control-label" for="idSaveCheck">ID保存</label>
                </div>
                
                
                <div class="custom-control custom-checkbox custom-control-inline">
               		 <input type="checkbox" class="custom-control-input" id="passwordSaveCheck" name="passwordSaveCheck" <?php if(isset($_COOKIE['userPassword'])) echo "checked"?>>
                	<label class="custom-control-label" for="passwordSaveCheck">PASSWORD保存</label>
                </div>
                
    			<div class="form-group">
    				<button type="submit" name="login" class="btn btn-outline-primary btn-rounded waves-effect btn-block">ログイン</button>
    			</div>
    			
    			<div class="form-inline">
        			<button type="button" class="btn btn-outline-info btn-rounded waves-effect col-sm-6" data-toggle="modal" data-target="#findUserId" style="margin:0">ID探す</button>
        			<button type="button" class="btn btn-outline-info btn-rounded waves-effect col-sm-6" data-toggle="modal" data-target="#findUserPassword" style="margin:0">PASSWORD探す</button>
    			</div>
    			
    			
    			<!-- Google, FaceBook, ログイン -->
    			<div style="text-align : center; margin-top:30px">
            		<a type="button" class="light-blue-text mx-2">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a type="button" class="light-blue-text mx-2">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a type="button" class="light-blue-text mx-2">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a type="button" class="light-blue-text mx-2">
                        <i class="fab fa-github"></i>
                    </a> 
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
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/user.js"></script>​
</body>
</html>