<?php
session_start();
if(!isset($_SESSION['userInfo'])){
    $errorMsg = "ログインしてください。";
    $path = "login";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>売り上げ|フリマシステム</title>
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

	<div class="container" style="margin-top:50px">
		<hr>
		<div>
    		<h4 class="text-dark font-weight-bold" style="float:left;"><span id="salesYearTitle" style="display:none"></span><span id="salesMonthTitle" style="display:none"></span>売り上げ</h4>
		</div>
		<!-- 売り上げリスト -->
		<div style="clear:both">
         	<select class="browser-default custom-select col-sm-3" id="salesYear" name="salesYear">
                <option value="">年を入力してください。</option>
                <?php for($i = date('Y', time()); $i >= date('Y', time())-5; $i--){ ?>
				<option value="<?=$i ?>"><?=$i ?>年</option>
				<?php }	?>
    		</select>
            <select class="browser-default custom-select col-sm-3" id="salesMonth" name="salesMonth">
                <option value="">月を入力してください。</option>
                <?php for($i = 1; $i <= 12; $i ++) {?>
                <option value="<?=$i ?>"><?=$i ?>月</option>
                <?php }?>
    		</select>                
		</div>
		
		<div>
			<table class="table table-hover">
				<thead>
    				<tr>
    					<th style="width:10%; text-align:center;">画像</th>
						<th style="width:15%; text-align:center;">出品者(ユーザーID)</th>
						<th style="width:25%; text-align:center;">出品名（出品地）</th>
						<th style="width:15%; text-align:center;">価格</th>
						<th style="width:15%; text-align:center;">売買日</th>
						<th style="width:10%; text-align:center;">手数料</th>
						<?php if($_SESSION['userInfo']['user_authority'] == 1){?>
						<th style="width:10%; text-align:center;">売り上げ</th>
						<?php }?>
    				</tr>
				</thead>
				<tbody id="salesListTable" style="text-align:center;"></tbody>
			</table>
		</div>
	</div>


	 <!-- 詳細情報MODAL -->
	<div class="modal" id="detailUserModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="detailUser" name="detailUser" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">詳細情報<span id="detailUserDeleteCheckModal"></span></h4>
                        <button type="button" class="close detailUserModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<div style="float : right;">
                    		登録日：<span id="detailUserCreatedateModal"></span>&nbsp;修正日：<span id="detailUserUpdatedateModal"></span>&nbsp;脱退日：<span id="detailUserDeletedateModal"></span>
                    	</div>
                    	<table class="table form-group">
                        	<tr>
                        		<td>ID：</td>
                        		<td id="detailUserIdModal"></td>
                        		<td>いいね：<span id="detailUserLikeCountModal"></span></td>
                        		<td>悪い：<span id=detailUserHateCountModal></span></td>
                    		</tr>
                    		<tr>
                    			<td>名前：</td>
                    			<td id="detailUserNameModal" colspan="3"></td>
                			</tr>
                			<tr>
                    			<td>生年月日：</td>
                    			<td id="detailUserBirthModal" colspan="3"></td>
                    		</tr>
                    		<tr>
                    			<td>電話番号：</td>
                    			<td id="detailUserPhoneModal" colspan="3"></td>
                    		</tr>
                    		<tr>
                    			<td>E-メール：</td>
                    			<td id="detailUserEmailModal" colspan="3"></td>
                    		</tr>
                    		<tr>	
                				<td>住所：</td>
                				<td id="detailUserAddressModal" colspan="3"></td>
            				</tr>
                    	</table>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                   		<button type="button" class="btn btn-danger detailUserModalClose" data-dismiss="modal">取消</button>
                    </div>
				</form>	
			</div>
		</div>
	</div>
	
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/fleamarket.js"></script>
<script>
var year = "";
var month = "";
$('#salesYear').change(function(){
	year = $(this).val(); salesList();
	if(year == ""){
		$('#salesYearTitle').hide();
	}else{
		$('#salesYearTitle').html(year+"年");
		$('#salesYearTitle').show();
	}
	
});
$('#salesMonth').change(function(){	
	month = $(this).val(); salesList();
	if(month == ""){
		$('#salesMonthTitle').hide();
	}else{
		$('#salesMonthTitle').html(month+"月");
		$('#salesMonthTitle').show();
	}
		
});

/*売り上げリスト一覧 */
function salesList(){
	$('#salesListTable').html('');
	$.ajax({
		type : 'POST',
		url : './salesAjax.php',
		data : {
			year : year,
			month : month,
			userNo : <?=$_SESSION['userInfo']['user_no']?>
		},
		success : function(result){
			console.log(result);
			if(result == '8'){
				alert('ログインしてください。');
				location.href='../index.php';
				return;
			}
			var total = 0;
			var userIncome = 0;
			var dataInput = "";
			
			for(var i = 0; i < result['result'].length; i++){
				var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
				if(result['result'][i].goods_filerealname == null){
					img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">'
				}
				
				total += Number(result['result'][i].goods_cprice);
				userIncome += Number(result['result'][i].goods_price -result['result'][i].goods_cprice); 
				dataInput = dataInput +
            				'<tr>' +
            				'<td><a href="../goods/goodsDetail.php?goods_no='+result['result'][i].goods_no+'">'+img+'</a></td>' +
            				'<td><a href=\'javascript:void(0);\' onclick=\'userDetailModal('+result['result'][i].user_no+')\'>'+result['result'][i].user_id+'</a></td>' +
            				'<td>'+result['result'][i].goods_area+'</td>' +
            				'<td>'+result['result'][i].goods_price+'円</td>' +
            				'<td>'+result['result'][i].buy_createdate+'</td>' +
            				'<td>'+result['result'][i].goods_cprice+'円</td>'
            				;
				if(<?=$_SESSION['userInfo']['user_authority']?> == '1'){
					dataInput = dataInput + '<td>'+(result['result'][i].goods_price - result['result'][i].goods_cprice)+'</td>';
				}
				dataInput = dataInput + '</tr>';
			}

			if(<?=$_SESSION['userInfo']['user_authority']?> == '1'){
				dataInput = dataInput +
                			'<tr>' +
                			'<td colspan="6">合計</td>' +
                			'<td>'+userIncome+'円</td>' +
                			'</tr>';
			}else{
    			dataInput = dataInput +
                			'<tr>' +
                			'<td colspan="5">合計</td>' +
                			'<td>'+total+'円</td>' +
                			'</tr>';
			}
			$('#salesListTable').html(dataInput);
        			
			
		}
	});
}
$(document).ready(function(){
	salesList();
});
</script>
</body>
</html>