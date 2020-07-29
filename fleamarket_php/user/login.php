<?php 
session_start();
require_once '../db/connection.php';
require_once './user.inc';
$model = new UserModel();
$model->getForm();
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
    		<form id="loginForm" name="loginForm">
    			<input type="hidden" id="userCmd" name="userCmd" value="login">
    			<div class="md-form">
    				<i class="fas fa-user prefix"></i>
                    <input  type="text" class="form-control" id="userId" name="userId" value="<?php if(isset($_COOKIE['userIdLogin'])) echo $_COOKIE['userIdLogin']?>">
                    <label for="userId">IDを入力してください。</label>
                </div>
        		<div class="md-form">
        			<i class="fas fa-lock prefix"></i>
                    <input  type="password" class="form-control" id="userPassword" name="userPassword" value="<?php if(isset($_COOKIE['userPasswordLogin'])) echo $_COOKIE['userPasswordLogin']?>">
                    <label for="userPassword">パスワードを入力してください。</label>
                </div>

				<div class="custom-control custom-checkbox custom-control-inline">
             		   <input type="checkbox" class="custom-control-input" id="idSaveCheck" name="idSaveCheck" <?php if(isset($_COOKIE['userIdLogin'])) echo "checked"?>>
                		<label class="custom-control-label" for="idSaveCheck">ID保存</label>
                </div>
                
                
                <div class="custom-control custom-checkbox custom-control-inline">
               		 <input type="checkbox" class="custom-control-input" id="passwordSaveCheck" name="passwordSaveCheck" <?php if(isset($_COOKIE['userPasswordLogin'])) echo "checked"?>>
                	<label class="custom-control-label" for="passwordSaveCheck">PASSWORD保存</label>
                </div>
                
    			<div class="form-group">
    				<button type="button" name="login" class="btn btn-outline-primary btn-rounded waves-effect btn-block" onclick="loginCheck()">ログイン</button>
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
	<input type="hidden" id="findPasswordIdhidden" name="findPasswordIdhidden">
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
                <div class="modal-footer" id="passwordSearch1">
                	<button type="submit" class="btn btn-primary" onclick="findUserPassword.findUserPasswordAjax()">探す</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
                
                <div class="modal-footer" id="passwordSearch2" style="display:none; text-align:left;">
                	<input type="text" id="certificationNumber" name="certificationNumber" class="form-control col-sm-3" placeholder="認証番号">
                	<button type="submit" class="btn btn-primary" onclick="findUserPassword.certificationNumberCheck()">認証</button>
                </div>
			</div>
		</div>
	</div>
	
	<!-- 新しいパスワード登録MODAL -->
	<div class="modal" id="newPasswordInsert">
		<div class="modal-dialog">
			<div class="modal-content">
    			<form>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">新しいパスワード登録</h4>
                        <button type="button" class="close ModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    <input type="hidden" id="newUserId" name="newUserId" value="">
                    <!-- Modal body -->
                    <div class="modal-body">
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			新パスワード：&nbsp;<input type="password" id="newUserPassword" name="newUserPassword" class="form-control">
                   		</div>
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			新パスワード(確認)：&nbsp;<input type="password" id="newUserPasswordCheck" name="newUserPasswordCheck" class="form-control">
                   		</div>
                   		<span id="passwordCheckResult" ></span>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="findUserPassword.newIdPasswordUpdate()">変更</button>
                   		<button type="button" class="btn btn-danger ModalClose" data-dismiss="modal">取消</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../btjs/fleamarket.js"></script>​
</body>
</html>