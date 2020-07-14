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

$sql = "
        SELECT
            *
            FROM
                userinfo
            ORDER BY
                user_no
        ";
/**
 * SQLを実行しデータを取得する
 * @var unknown $result
 */
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員管理 | フリマシステム</title>
<!-- Bootstrap core CSS -->
<link href="../btcss/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="../btcss/mdb.min.css" rel="stylesheet">
<!-- Your custom styles (optional) -->
<link href="../btcss/style.css" rel="stylesheet">
<!-- MDBootstrap Datatables  -->
<link href="../btcss/addons/datatables2.min.css" rel="stylesheet">

<link rel="stylesheet" href="../css/user.css">
</head>
<body>

<?php require_once '../menu/menunav.php';?>

<div class="container">
	<div style="margin-top:100px;">
		<h1>会員管理</h1>
	</div>

	<table class="table" id="dtBasicExample">
		<thead>
			<tr>
				<th style="width:5%;">No.</th>
				<th style="width:10%;">ID</th>
				<th style="width:10%;">名前</th>
				<th style="width:20%;">評価(いいね、悪い)</th>
				<th style="width:15%;">出品数</th>
				<th style="width:15%;">販売完了</th>
				<th style="width:15%;">登録日</th>
				<th style="width:10%;">会員有無</th>
			</tr>
		</thead>
      	<tbody id="userListResult">
			<?php 
			     if(mysqli_num_rows($result) > 0){
                    while($data = mysqli_fetch_assoc($result)){
            ?>
      		<tr>
				<td><?=$data['user_no']?></td>
    			<td><a href="javascript:void(0);" onclick="asdfasdf()" ><?=$data['user_id']?></a></td>
    			<td><?=$data['user_name']?></td>
    			<td>11</td>
    			<td>11</td>
    			<td>11</td>
    			<td><?=$data['user_createdate']?></td>
    			<td><?php $data['user_deletecheck'] == '0' ? print "会員" : print "非会員"?></td>
			</tr>
      		<?php 
                    }
                }
                mysqli_free_result($result);
                mysqli_close($conn);
            ?>
		</tbody>
		
	</table>
</div>



    <!-- 詳細情報変更MODAL -->
	<div class="modal" id="detaccilUser">
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
                    	<button type="button" class="btn btn-primary" onclick="return isDetailUserUpdate();">変更</button>
                   		<button type="button" class="btn btn-danger detailUserUpdateModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/user.js"></script>
  <!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="../btjs/addons/datatables2.min.js"></script>
<script>
$(document).ready(function () {
	  $('#dtBasicExample').DataTable({
		  "ordering": false
		  });
	  
	  $('.dataTables_length').addClass('bs-select');
	});

function asdfasdf(){
	$('#detaccilUser').on('show.bs.modal', function() {          
       
    });
}
/* function userSearch(){
	var userSearch = $('#userSearch').val();
	$.ajax({
		type : "POST",
		url : "./searchUserAjax.php",
		data : {userSearch : userSearch},
		success : function(data){
			$('#userListResult').html('');
			dataTable(data);
		} 
	});
}

function dataTable(data){
	if(data){
		alert(data['result'][0].userNo);
		for(var i = 0; i < data['result'].length; i++){
			var userNo = data['result'][i].userNo;
			var userId = data['result'][i].userId;
			var userName = data['result'][i].userName;
			var userLikeCount = data['result'][i].userLikeCount;
			var userHateCount = data['result'][i].userHateCount;
			var userCreateDate = data['result'][i].userCreateDate;
			var userDeleteCheck = data['result'][i].userDeleteCheck;

			if(userDeleteCheck == '0') {
				userDeleteCheck = '会員';
			}else{
				userDeleteCheck = '非会員';
			}
			$('#userListResult').append("<tr>"+
										"<td>"+userNo+"</td>"+
										"<td><a href='javascript:void(0);' onclick=\"modalFunction(\'"+data+"\')\";>"+userId+"</a></td>"+
										"<td>"+userName+"</td>"+
										"<td>いいね："+userLikeCount+"、悪い："+userHateCount+"</td>"+
										"<td>11</td>"+
										"<td>11</td>"+
										"<td>"+userCreateDate.substring(0, 11)+"</td>"+
										"<td>"+userDeleteCheck+"</td>"+
										"</tr>"
					);
			
			
		}
	}
} */
</script>
</body>
</html>