function openGoodsInsertModal(){
	$('#goodsInsertModal').modal('show');
}
/**
 * 登録して表示する
 * @returns
 */
function goodsInsert(){
	if($('#goodsTitle').val() == ''){
		alert('タイトルを入力してください。');
		$('#goodsTitle').focus();
		return false;
	}
	if($('#goodsPrice').val() == ''){
		alert('価格を入力してください。');
		$('#goodsPrice').focus();
		return false;
	}
	if($('#goodsContent').val() == ''){
		alert('内容を入力してください。');
		$('#goodsContent').focus();
		return false;
	}
		
	var formData = new FormData($("#goodsInsertForm")[0]);
	$.ajax({
		type : 'POST',
		url : "./goodsInsertAjax.php",
		processData: false, 
		contentType: false,
		data : formData,
		success : function(result){
			console.log(result);
			$('#goodsDiv').html('');
			$('#goodsTitle').val('');
			$('#goodsPrice').val('');
			$('#goodsContent').val('');
			$('#goodsInsertModal').modal('hide');
			goodsDivAppend(result);
		}
	});
}


/**
 * 検索する
 * @returns
 */
var goodsArea = '';
$("#goodsAreaSelect").change(function(){
	goodsArea = $(this).val();
	goodsAllList();
})
function goodsAllList(){
	
	var searchGoods = $('#goodsSearch').val();
	if(goodsArea != '') goodsArea = goodsArea;
	
	$.ajax({
		type : 'POST',
		url : "./goodsAllListAjax.php",
		data : {
			searchGoods : searchGoods,
			goodsArea : goodsArea
			},
		success : function(result){
			$('#goodsDiv').html('');	
			goodsDivAppend(result);
		}
	});
}

/**
 * 商品リスト表示する
 * @param result
 * @returns
 */
function goodsDivAppend(result){
	if(goodsArea != '')	{
		$('#goodsAreaList').html('('+result['result'][0].goods_area+')');
	}else{
		$('#goodsAreaList').html('');
	}
	
	
	for(var i = 0; i < result['result'].length; i++){
		/* 条件によって写真が変わる */
		var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
		var button = '<button type="button" class="btn btn-info btn-sm" onclick="insertIntoCart(\''+result['result'][i].goods_no+'\')" >カートに入れる</button>';
		if(result['result'][i].goods_filerealname == null){
			img = '<img src="../img/noImg.jpg" style="max-height: 74px; max-width: 74px">'
		}
		
		if(result['result'][i].goods_onsale == '1'){
			img = '<img src="../img/soldout.png" style="max-height: 74px; max-width: 74px">';
		}

		if (result['userAuthority'] == "9"){
			if(result['result'][i].goods_onsale == '1' && result['result'][i].goods_commission == '1'){ 
				button = '<button type="button" class="btn btn-danger btn-sm" onclick="#" >要請完了</button>';
			}else if(result['result'][i].goods_onsale == '1' && result['result'][i].goods_commission == '0') {
				button = '<button type="button" class="btn btn-success btn-sm" onclick="commissionCreate(\''+result['result'][i].goods_no+'\')" >手数料要請</button>';
			}else{
				button ="";
			}
		} else{
			if(result['result'][i].goods_onsale == '1')	button = "";
		}

		$('#goodsDiv').append(
				'<hr>'+
				'<div style="display: flex;flex-direction: row">' +
				'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">' +
				img +
				'</div>'+
				'<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">' +
				'<h5 style="margin:0" class="text-dark font-weight-bold"><a href="./goodsDetail.php?goods_no='+result['result'][i].goods_no+'" >'+ result['result'][i].goods_title +'</a></h5>' +
				'<p style="margin-bottom:10px"><span class="text-dark font-weight-bold">' + result['result'][i].goods_price + '円</span></p>' +
				'<p style="margin:0"><span class="text-dark">' + result['result'][i].goods_content + '</span></p>' +
				'</div>' +
				'<div style="margin: 2px; padding: 5px; flex: 0 1 20%;">' +
				'<p style="margin:0">修正日：' + result['result'][i].goods_updatedate + '</p>' +
				'<p style="margin-bottom:10px">登録日：' + result['result'][i].goods_createdate+ '</p>' +
				'<p style="margin:0">'+button+'</p>' +
				'</div>' +
				'</div>' 
				);
		
	}
}
/**
 * 手数料要請する
 * @param goodsNo
 * @returns
 */
function commissionCreate(goodsNo){
	$.ajax({
		type : 'POST',
		url : './commissionCreateAjax.php',
		data : {goodsNo : goodsNo},
		success : function(result){
			if(result){
				alert('手数料要請しました。');
				location.href='./goodsList.php';
			}else{
				alert('手数料要請に失敗しました。');
			}
		}
	});
}

/**
 * 削除確認Modalを表示する
 * @returns
 */
function goodsDeleteModal(){
	$('#goodsDeleteModal').modal('show');
}
/**
 * パスワード確認後データを削除する
 * @returns
 */
function goodsDelete(){
	var goodsNo = $('#goodsDeleteForm [name="goodsNo"]').val();
	var userPassword = $('#goodsDeleteForm [name="userPassword2"]').val();
	
	$.ajax({
		type : 'POST',
		url : './goodsDeleteAjax.php',
		data : {
			goodsNo : goodsNo,
			userPassword : userPassword
		},
		success : function(result){
			if(result){
				alert("削除しました。");
				location.href="./goodsList.php";
			}else{
				alert("パスワードを確認してください。");
			}
		}
	});
}

/**
 * 商品更新MODALを表示する
 * @returns
 */
function goodsUpdateModal(){
	$('#goodsUpdateModal').modal('show');
}

/**
 * データを更新する
 * @returns
 */
function goodsUpdate(){

	if($('#goodsUpdateForm [name="goodsTitle"]').val() == ''){
		alert('タイトルを入力してください。');
		$('#goodsUpdateForm [name="goodsTitle"]').focus();
		return false;
	}
	if($('#goodsUpdateForm [name="goodsPrice"]').val() == ''){
		alert('価格を入力してください。');
		$('#goodsUpdateForm [name="goodsPrice"]').focus();
		return false;
	}
	if($('#goodsUpdateForm [name="goodsContent"]').val() == ''){
		alert('内容を入力してください。');
		$('#goodsUpdateForm [name="goodsContent"]').focus();
		return false;
	}
	
	var formData = $('#goodsUpdateForm').serialize();
	console.log(formData);
	$.ajax({
		type : 'POST',
		url : './goodsUpdateAjax.php',
		data : formData,
		success : function(result){
			if(result){
				alert('更新しました。');
				location.href='./goodsDetail.php?goods_no='+$('#goodsUpdateForm [name="goodsNo"]').val();
			}else{
				alert('失敗しました。');
			}
		}
	});
}



/**
 * コメント管理
 */
var commentManager = new function(){
	
	/**
	 * コメント登録する
	 */
	this.insert= function(data){
		var goodsNo = data.goodsNo.value;
		var goodsCommentContent = data.goodsCommentContent.value;
		var userNo = data.userNo.value;
		
		
		if(goodsCommentContent == ''){
			alert('コメントを入力してください。');
			$('#goodsCommentContent').focus();
			return false;
		}
		if(userNo == ''){
			alert('ログインしてください。');
			$('#goodsCommentContent').val('');
			$('#goodsCommentContent').focus();
			return false;
		}

		$.ajax({
			type : 'POST',
			url : "./goodsCommentCreateAjax.php",
			data : {
				goodsNo : goodsNo,
				goodsCommentContent : goodsCommentContent,
				userNo : userNo
			},
			success : function(result){	
				$('#goodsCommentContent').val('');
				commentManager.list(goodsNo, userNo);
				}
		});
	}
	
	this.deleteFunction = function(goodsNo, commentNo){
		$.ajax({
			type : 'POST',
			url : './commentDeleteAjax.php',
			data : {
				goodsNo : goodsNo,
				commentNo : commentNo
				},
		success : function(result){	commentManager.list(goodsNo, result);}
		});
	}
	
	this.list = function(goodsNo, userNo){
		$.ajax({
			type : 'POST',
			url : "./commentListAjax.php",
			data : {
				goodsNo : goodsNo
			},
			success : function(result){
				$('#goodsCommentList').html('');
				$('#goodsCommentForm [name="goodsCommentContent"]').val('');
				for(var i = 0; i < result['result'].length; i++){
					var deleteButton = "";
					if(result['result'][i].user_no == userNo){
						deleteButton ='<span style="float:right;"><a href="javascript:void(0);" onclick="commentManager.deleteFunction(\''+result['result'][i].goods_no+'\', \''+result['result'][i].goods_comment_no+'\')">削除</a></span>';
					}
					$('#goodsCommentList').append(
							'<hr style="margin-top:30px; margin-bottom:0px;">' +
							'<div>' +
							'<span style="float:left">'+result['result'][i].user_id+'</span>' +
							'<span style="float:right">'+result['result'][i].goods_comment_createdate+'</span>' +
							'</div>' +
							'<div style="clear:both"></div>' +
							'<div>'+
							'<span style="float:left">' +result['result'][i].goods_comment_content+'</span>' +
							 deleteButton +
							'</div>'
								);
				}
			}
		});
	}
}

function userChat(formID, toID){
	$.post("", {user_id : toID});
	
	
}
