<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員管理 | フリマシステム</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/user.css">
<script>
window.onload = function(){
	$.ajax({
		type : "POST",
		url : "./listUserAjax.php",
		success : function(data){
			if(data){
				for(var i = 0; i < data['result'].length; i++){
					var userNo = data['result'][i].userNo;
					var userId = data['result'][i].userId;
					var userName = data['result'][i].userName;
					var userCreateDate = data['result'][i].userCreateDate;
					var userDeleteCheck = data['result'][i].userDeleteCheck;
					if(userDeleteCheck == '0') {
						userDeleteCheck = '会員';
					}else{
						userDeleteCheck = '非会員';
					}
					$('#userListResult').append("<tr>"+
												"<td>"+userNo+"</td>"+
												"<td><a href='#' data-toggle='modal' data-target='#detailUser'>"+userId+"</a></td>"+
												"<td>"+userName+"</td>"+
												"<td>11</td>"+
												"<td>11</td>"+
												"<td>11</td>"+
												"<td>"+userCreateDate.substring(0, 11)+"</td>"+
												"<td>"+userDeleteCheck+"</td>"+
												"</tr>"
							);
					
					
				} 
			}
		}
	});
}
</script>
</head>
<body>

<?php require_once '../menu/menunav.php';?>

<div class="container">
	<table class="table">
		<thead>
			<tr style="">
				<th style="width:5%;">No.</th>
				<th style="width:15%;">ID</th>
				<th style="width:15%;">名前</th>
				<th style="width:20%;">評価(いいね、悪い)</th>
				<th style="width:10%;">出品数</th>
				<th style="width:10%;">販売完了</th>
				<th style="width:15%;">登録日</th>
				<th style="width:10%;">会員有無</th>
			</tr>
		</thead>
		<tbody id="userListResult">
		</tbody>
	</table>
</div>






    <!-- 詳細情報変更MODAL -->
	<div class="modal" id="detailUser">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="detailUserUpdate" name="detailUserUpdate" method="post">
					<input type="hidden" id="userNo" name="userNo" value="<?=$data['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">詳細情報</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<table class="table form-group">
                        	<tr>
                        		<td>ID：</td>
                        		<td><?=$data['user_id'] ?></td>
                        		<td>パスワード：</td>
                        		<td><button type="button" class="btn btn-primary"  data-dismiss="modal" data-toggle="modal" data-target="#passwordUpdate" >パスワード変更</button></td>
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
                    	<button type="button" class="btn btn-primary" onclick="#">変更</button>
                   		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
				</form>	
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