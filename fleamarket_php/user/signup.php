<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員登録 | フリマシステム</title>
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
    		
    	<div class="col-lg-4">
    		<h3 style="text-align:center; margin-top:20px;">会員登録</h3>
    		<form id="signupForm" name="signupForm">
    			<input type="hidden" id="userCmd" name="userCmd" value="signup">
				<div class="md-form form-sm form-inline" style="margin:0">
					<input class="form-control form-control-sm col-sm-6" type="text" id="userId" name="userId" value="">&nbsp;
					<label for="userId">IDを入力してください。</label>
					<button type="button" class="btn btn-default" onclick="userIdCheck();">重複チェック</button>
					<button type="button" class="btn btn-primary" id="changeId" style="display:none;">ID修正</button>
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="password" id="userPassword" name="userPassword" value="">
					<label for="userPassword">PassWordを入力してください。</label>
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="password" id="userPasswordCheck" name="userPasswordCheck" value="">
					<label for="userPasswordCheck">PassWord(確認)を入力してください。</label>
					<span id="passwordCheckResult"></span>
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="text" id="userName" name="userName" value="">
					<label for="userName">名前を入力してください。</label>
				</div>
				<div class="form-inline">
					<select class="form-control" id="year" name="year">
						<option value="">年</option>        						
						<?php for($i = date('Y', time()); $i >= date('Y', time())-100; $i--){ ?>
    					<option value="<?=$i ?>"><?=$i ?></option>
						<?php }	?>
					</select>&nbsp;年&nbsp;&nbsp;
					<select class="form-control" id="month" name="month">
						<option value="">月</option>        						
						<?php for($i = 1; $i <= 12; $i++){ ?>
    					<option value="<?=$i ?>"><?=$i ?></option>
						<?php }	?>
					</select>&nbsp;月&nbsp;&nbsp;
					<select class="form-control" id="day" name="day">
						<option value="">日</option>        						
						<?php for($i = 1; $i <= 31; $i++){ ?>
    					<option value="<?=$i ?>"><?=$i ?></option>
						<?php }	?>
					</select>&nbsp;日&nbsp;&nbsp;
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="text" id="userPhoneNumber" name="userPhoneNumber" value="">
					<label for="userPhoneNumber">電話番号を入力してください。</label>
				</div>
				<div class="md-form form-sm form-inline" style="margin:0">
					<input class="form-control form-control-sm col-sm-6" type="email" id="userEmail" name="userEmail" value="">&nbsp;
					<label for="userEmail">E-メールを入力してください。</label>
					<button type="button" class="btn btn-default" onclick="userEmailCheck();">重複チェック</button>
					<button type="button" class="btn btn-primary" id="changeEmail" style="display:none;">メール修正</button>
				</div>
				<div class="md-form form-sm form-inline">
					<input class="form-control form-control-sm col-sm-4" type="text" id="userZipCode" name="userZipCode" value="">&nbsp;
					<label for="userZipCode">郵便番号</label>
					<button type="button" class="btn btn-default" onclick="searchZipCode();">検索</button>
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="text" id="userAddress1" name="userAddress1" value="">
					<label for="userAddress1">都道府県</label>
				</div>
				<div class="md-form form-sm">
					<input class="form-control form-control-sm" type="text" id="userAddress2" name="userAddress2" value="">
					<label for="userAddress2">詳細住所を入力してください。（選択）</label>
				</div>
            	<div class="div-right">
            		<button type="button" class="btn btn-primary" onclick="signupCheck()">会員登録</button>
            		<button type="button" class="btn btn-danger" onclick="history.back();">取消</button>
        		</div>
    		</form>
    	</div>
    	<div class="col-lg-4"></div>
	</div>
	
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../btjs/fleamarket.js"></script>
</body>
</html>