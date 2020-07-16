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
 * SQL文(ユーザーに該当するデータを取得する)
 * @var Ambiguous $sql
 */
$sql = "
        SELECT *
            FROM userinfo
            WHERE user_id = '{$_SESSION['userInfo']['user_id']}'
        ";

/**
 * SQLを実行しデータを取得する
 * @var unknown $result
 */
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
   $data = mysqli_fetch_assoc($result); 
   mysqli_free_result($result);
   mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員情報 | フリマシステム</title>
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
	<div class="container">
    	<div class="row">
    		<div class="col-lg-3" style="height:100%">
    			<h1 class="my-4">会員情報</h1>
    			<div class="list-group">
                	<button type="button" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#passwordUpdate">パスワード変更	</button>
                	<button type="button" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#deleteUser">会員脱退</button>
                </div>
    		</div>	
	
        	<div class="col-lg-9">
        		<div style="margin-top:100px; text-align:right;">
        			<span>登録日：<?=$data['user_createdate'] ?></span>
        		</div>
        		<table class="table">
        			<thead>
            			<tr>
            				<td>ID：</td>
            				<td><?=$data['user_id'] ?></td>
            				<td>PASSWORD：</td>
            				<td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#passwordUpdate" style="margin:0">パスワード変更</button></td>
            			</tr>
            			<tr>
            				<td>名前：</td>
            				<td><?=$data['user_name'] ?></td>
            				<td>生年月日：</td>
            				<td><?=$data['user_birth'] ?></td>
            			</tr>
            			<tr>
            				<td>電話番号：</td>
            				<td><?=$data['user_phone'] ?></td>
            				<td>E-メール：</td>
            				<td><?=$data['user_email'] ?></td>
            			</tr>
            			<tr>
            				<td>住所</td>
            				<td colspan="3"><?="(".$data['user_zipcode'].")".$data['user_address1']." ".$data['user_address2'] ?></td>
            			</tr>
            			<tr>
            				<td>お問い合わせ数：</td>
            				<td><a href="#">1</a></td>
            				<td>出品数：</td>
            				<td><a href="#">1</a></td>
            			</tr>
        			</thead>
        		</table>	
        		<div class="div-right">
        			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailUpdate">情報更新</button>
        			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUser">会員脱退</button>
        		</div>
        	</div>
    	</div>
	</div>
	
	
	
	
	
	<!-- 詳細情報変更MODAL -->
	<div class="modal" id="detailUpdate">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="detailUserUpdate" name="detailUserUpdate" method="post">
					<input type="hidden" id="userNo" name="userNo" value="<?=$data['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">詳細情報変更</h4>
                        <button type="button" class="close detailUserUpdateModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<table class="table form-group">
                        	<tr>
                        		<td>ID：</td>
                        		<td><?=$data['user_id'] ?></td>
                        		<td>パスワード：</td>
                        		<td><button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" data-toggle="modal" data-target="#passwordUpdate" >パスワード変更</button></td>
                    		</tr>
                    		<tr>
                    			<td>名前：</td>
                    			<td><?=$data['user_name'] ?></td>
                    			<td>生年月日：</td>
                    			<td><?=$data['user_birth'] ?></td>
                    		</tr>
                    		<tr>
                    			<td>電話番号：</td>
                    			<td colspan="3"><input type="text" class="form-control" id="userPhoneNumber" name="userPhoneNumber" value="<?=$data['user_phone'] ?>" placeholder="電話番号を入力してください。"></td>
                    		</tr>
                    		<tr>
                    			<td>E-メール：</td>
                    			<td colspan="3">
                    				<input type="text" class="form-control" id="userEmail" name="userEmail" value="<?=$data['user_email'] ?>" placeholder="E-メールを入力してください。">
                    			</td>
                    		</tr>
                    		<tr>	
                				<td>住所：</td>
                				<td class="form-inline">
                					<input class="form-control" type="text" id="userZipCode" name="userZipCode" value="<?=$data['user_zipcode'] ?>" placeholder="郵便番号">&nbsp;
                					<button type="button" class="btn btn-default" onclick="searchZipCode();">検索</button>
                				</td>
            				</tr>
            				<tr>
                				<td></td>
                				<td colspan="3"><input class="form-control" type="text" id="userAddress1" name="userAddress1" value="<?=$data['user_address1'] ?>" placeholder="都道府県"></td>
                			</tr>
                			<tr>
                				<td></td>
                				<td colspan="3"><input class="form-control" type="text" id="userAddress2" name="userAddress2" value="<?=$data['user_address2'] ?>" placeholder="詳細住所を入力してください。（選択）"></td>
                			</tr>
                			
                    	</table>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="return isDetailUserUpdate();">変更</button>
                   		<button type="button" class="btn btn-danger detailUserUpdateModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
	
	
	<!-- パスワード変更MODAL -->
	<div class="modal" id="passwordUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="./passwordUpdate.php" method="post" onsubmit="return updatePasswordCheck()">
					<input type="hidden" id="userNo" name="userNo" value="<?=$data['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">パスワード変更</h4>
                        <button type="button" class="close passwordUpdateModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			元パスワード：&nbsp;<input type="password" id="oldPassword" name="oldPassword" class="form-control">
                   		</div>
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			新パスワード：&nbsp;<input type="password" id="newPassword1" name="newPassword1" class="form-control">
                   		</div>
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			新パスワード(確認)：&nbsp;<input type="password" id="newPassword2" name="newPassword2" class="form-control">
                   		</div>
                   		<span id="passwordCheckResult" ></span>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="submit" class="btn btn-primary">変更</button>
                   		<button type="button" class="btn btn-danger passwordUpdateModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
	<!-- パスワード変更MODAL -->
	<div class="modal" id="deleteUser">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="./deleteUser.php" method="post" onsubmit="return deleteUser()">
					<input type="hidden" id="userNo" name="userNo" value="<?=$data['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">会員脱退</h4>
                        <button type="button" class="close passwordUpdateModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<div>
                    		<h6 class="text-danger">本当に脱退しますか？<small>(パスワードを入力してください。)</small></h6>
                    	</div>
                   		<div class="form-inline" style="margin-bottom: 10px;">
                   			パスワード確認：&nbsp;<input type="password" id="userPassword" name="userPassword" class="form-control">
                   		</div>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="submit" class="btn btn-primary">脱退</button>
                   		<button type="button" class="btn btn-danger passwordUpdateModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/user.js"></script>
    ​
</body>
</html>
