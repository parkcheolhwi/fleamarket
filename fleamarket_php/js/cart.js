/**
 * カートに登録する
 * @returns
 */
function insertIntoCart(goodsNo){

	$.ajax({
		type : 'POST',
		url : '../cart/insertCartAjax.php',
		data : {
			goodsNo : goodsNo
			},
		success : function(result){
			if(result =='8'){
				alert('ログインしてください。');
			}else if(result =='11'){
				alert('販売完了された商品です。');
			}else if(result == '9'){
				alert('同じ商品が存在します。');
			}else if (result == '0'){
				alert('失敗しました。');				
			}else if (result == '1'){
				alert('登録しました。');				
			}
			
		}
	});
	
}
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
function buyInserCheck(){
	var goodsNo = [];
	if(typeof($('#goodsDetailForm [name="goodsNo"]').val()) != 'undefined'){
		goodsNo.push($('#goodsDetailForm [name="goodsNo"]').val());
	}else{
		$('input[name=goodsChecked]:checked').each(function(i){
			goodsNo.push($(this).val());
		});
	}
	
	
	$.ajax({
		type : 'POST',
		url : '../cart/cartBuyCheckAjax.php',
		data : {goodsNo:goodsNo},
		success : function(result){
			$('#cartBuyCheckList').html('');
			for(var i = 0; i < result['result'].length; i++){
				var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
				if(result['result'][i].goods_filerealname == null){
					img = '<img src="../img/noImg.jpg" style="max-height: 74px; max-width: 74px">'
				}
			
				$('#cartBuyCheckList').append(
						'<hr>'+
						'<div style="display: flex;flex-direction: row">' +
						'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;" id="listImg">' +
						img +
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
	if(typeof($('#goodsDetailForm [name="goodsNo"]').val()) != 'undefined'){
		goodsNo.push($('#goodsDetailForm [name="goodsNo"]').val());
	}else{
		$('input[name=goodsChecked]:checked').each(function(i){
			goodsNo.push($(this).val());
		});
	}
	$.ajax({
		type : 'POST',
		url : '../buy/goodsBuyInsertAjax.php',
		data : {goodsNo : goodsNo},
		success : function(result){
			if(result == '11'){
				alert('購入完了された商品です。');
			}else if(result == '9'){
				alert('ログインしてください。');
			}else if(result == '1'){
				alert('購入しました。');
				location.href="../buy/buyList.php";
			}else if (result == '7'){
				alert('購入に失敗しました。');
			}
		}
	});
}


