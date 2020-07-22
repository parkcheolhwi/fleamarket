<?php


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>非会員チェック|フリマシステム</title>
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
    		<h3 style="text-align:center; margin-top:20px;">非会員チェック</h3>
			<div class="md-form">
				<i class="fas fa-user prefix"></i>
                <input  type="email" class="form-control" id="userEmail" name="userEmail">
                <label for="userEmail">E-メールを入力してください。</label>
            </div>
    		<div class="md-form">
    			<i class="fas fa-lock prefix"></i>
                <input  type="password" class="form-control" id="userPassword" name="userPassword">
                <label for="userPassword">パスワードを入力してください。</label>
            </div>
			<div class="form-group">
				<button type="button" name="login" class="btn btn-outline-primary btn-rounded waves-effect btn-block" onclick="nonUserCheck();">確認する</button>
			</div>
    	</div>
    	<div class="col-lg-5"></div>
	</div>


	<!-- 購入リストのModal -->
	<div class="modal" id="nonUserBuyModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="nonUserBuyName"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
            		<div id="nonUserBuyList"></div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
			</div>
		</div>
	</div>
	
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/user.js"></script>	
</body>
</html>