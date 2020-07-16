/**
 * カートに登録する
 * @returns
 */
$('#insertIntoCart').click(function(){
	var goodsNo = $('#goodsDetailForm [name="goodsNo"]').val();
	var userINo = $('#goodsDetailForm [name="userINo"]').val();
	if($('#goodsDetailForm [name="userINo"]').val() == ''){
		alert('ログインしてください。');
		return false;
	}
	
	$.ajax({
		type : 'POST',
		url : '../cart/insertCartAjax.php',
		data : {
			goodsNo : goodsNo,
			userINo : userINo
			},
		success : function(result){
			if(result == '9'){
				alert('同じ商品が存在します。');
			}else if (result == '0'){
				alert('失敗しました。');				
			}else if (result == '1'){
				alert('登録しました。');				
			}
			
		}
	});

});

/**
 * 該当するカート内訳を削除する
 * @param cartNo
 * @returns
 */
function cartDelete(cartNo){
	$.ajax({
		type : 'POST',
		url : './deleteCartAjax.php',
		data : {cartNo : cartNo},
		success : function(result){
			switch (result){
			case '9' :
				alert('データがありません。');
				break;
			case '1' :
				alert('削除されました。');
				location.href='./cartList.php';
				break;
			}
		}
	});
}

/**
 * チェックボックスによって購入するリストを表示する
 * @returns
 */
function cartInserCheck(){
	var goodsNo = [];
	$('input[name=goodsChecked]:checked').each(function(i){
		goodsNo.push($(this).val());
	});
	
	$.ajax({
		type : 'POST',
		url : './cartBuyCheckAjax.php',
		data : {goodsNo:goodsNo},
		success : function(result){
			$('#cartBuyCheckList').html('');
			for(var i = 0; i < result['result'].length; i++){
				$('#cartBuyCheckList').append(
						'<hr>'+
						'<div style="display: flex;flex-direction: row">' +
						'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;" id="listImg">' +
						'<img src="../img/123.jpg" style="max-height: 74px; max-width: 74px">' +
						'</div>'+
						'<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">' +
						'<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no='+result['result'][i].goods_no+'">'+ result['result'][i].goods_title +'</a></h5>' +
						'<p style="margin-bottom:10px"><span class="text-dark font-weight-bold">' + result['result'][i].goods_price + '</span></p>' +
						'<p style="margin:0"><span class="text-dark">' + result['result'][i].goods_content + '</span></p>' +
						'</div>' +
						'</div>' 
						);
			}
			$('#cartBuyCheckModal').modal('show');
		}
	});
}

function goodsBuy(){
	var goodsNo = [];
	$('input[name=goodsChecked]:checked').each(function(i){
		goodsNo.push($(this).val());
	});
	$.ajax({
		type : 'POST',
		url : '../buy/goodsBuyInsertAjax.php',
		data : {goodsNo : goodsNo},
		success : function(result){
			if(result == '1'){
				alert('購入しました。');
				location.href="./cartList.php";
			}else if (result == '9'){
				alert('購入に失敗しました。');
			}
		}
	});
}