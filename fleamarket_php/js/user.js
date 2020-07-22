
var inputDataCheck = new function(){
	this.userId = function(userId){
		if(userId == ''){
			alert('IDを入力してください。');
			$('#userId').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(userId)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#userId').val('');
			$('#userId').focus();
			return false;
		}
		return true;
	}
	
	this.oldPassword = function(oldPassword){
		if(oldPassword == ''){
			alert('旧パスワードを入力してください。');
			$('#oldPassword').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(oldPassword)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#oldPassword').val('');
			$('#oldPassword').focus();
			return false;
		}
		return true;
	}
	
	this.userDeletePassword = function(userDeletePassword){
		if(userDeletePassword == ''){
			alert('パスワードを入力してください。');
			$('#userDeletePassword').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(userDeletePassword)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#userDeletePassword').val('');
			$('#userDeletePassword').focus();
			return false;
		}
		return true;
	}
	
	this.userPassword = function(userPassword){
		if(userPassword == ''){
			alert('パスワードを入力してください。');
			$('#userPassword').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(userPassword)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#userPassword').val('');
			$('#userPassword').focus();
			return false;
		}
		return true;
	}
	
	this.userPasswordCheck = function(userPasswordCheck){
		if(userPasswordCheck == ''){
			alert('パスワードを入力してください。');
			$('#userPasswordCheck').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(userPasswordCheck)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#userPasswordCheck').val('');
			$('#userPasswordCheck').focus();
			return false;
		}
		return true;
	}
	
	this.userName = function(userName){
		if(userName == ''){
			alert('名前を入力してください。');
			$('#userName').focus();
			return false;
		}
		return true;
	}
	
	this.userBirth = function(year, month, day){
		if(year == '' || month == '' || day == ''){
			alert('生年月日を入力してください。');
			$('#year').focus();
			return false;
		}
		return true;
	}
	
	this.userPhoneNumber = function(userPhoneNumber){
		if(userPhoneNumber == ''){
			alert('電話番号を入力してください。');
			$('#userPhoneNumber').focus();
			return false;
		}
		return true;
	}
	
	this.userEmail = function(userEmail){
		if(userEmail == ''){
			alert('E-メールを入力してください。');
			$('#userEmail').focus();
			return false;
		}
		if(!/^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/.test(userEmail)){
			alert('E-メール形式が間違っています。');
			$('#userEmail').val('');
			$('#userEmail').focus();
			return false;
		}
		
		return true;
	}
	
	this.userZipCode = function(userZipCode){
		if(userZipCode == ''){
			alert('郵便番号を入力してください。');
			$('#userZipCode').focus();
			return false;
		}
		return true;
	}
	
	this.userAddress1 = function(userAddress1){
		if(userAddress1 == ''){
			alert('住所を入力してください。');
			$('#userAddress1').focus();
			return false;
		}
		return true;
	}
}

var userIdCheckResult = 0;
var userEmailCheckResult = 0;
/**
 * 空のデータをチェックする
 * @returns
 */
function signupCheck() {
	if(!inputDataCheck.userId($('#userId').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) return false;
	if(!inputDataCheck.userName($('#userName').val())) return false;
	if(!inputDataCheck.userBirth($('#year').val(), $('#month').val(), $('#day').val())) return false;
	if(!inputDataCheck.userPhoneNumber($('#userPhoneNumber').val())) return false;
	if(!inputDataCheck.userEmail($('#userEmail').val())) return false;
	if(!inputDataCheck.userZipCode($('#userZipCode').val())) return false;
	if(!inputDataCheck.userAddress1($('#userAddress1').val())) return false;
	if(userIdCheckResult == 0 || userEmailCheckResult == 0){
		alert('ID, Emailをチェックしてください。');
		return false;
	}
	
}

$('#userPhoneNumber').change(function(){
	var regexp = /^\d{11}$/;
	var phoneNumber = $('#userPhoneNumber').val();
	if( !regexp.test(phoneNumber) ) {

	alert("電話番号は11桁の数字を入力してください。");
		$('#userPhoneNumber').val('');
		$('#userPhoneNumber').focus();

	}else{
		var num1 = $('#userPhoneNumber').val().substring(0,3);
		var num2 = $('#userPhoneNumber').val().substring(3,7);
		var num3 = $('#userPhoneNumber').val().substring(7,11);
		$('#userPhoneNumber').val(num1+'-'+num2+'-'+num3);
	}
});

/**
 * パスワードが一致するかチェック
 * @returns
 */
$('#userPassword').change(function(){
	if(!inputDataCheck.userPassword($('#userPassword').val())) {
		return false;
	}
})
$('#userPasswordCheck').change(function(){

	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) {return false;}

	if($('#userPassword').val() == $('#userPasswordCheck').val()){
		$('#passwordCheckResult').html('パスワードが一致します。');
		$('#passwordCheckResult').css('color', 'blue');
	}else{
		$('#userPassword').focus();
		$('#passwordCheckResult').html('パスワードが一致しません。');
		$('#passwordCheckResult').css('color', 'red');
	}
})


/**
 * ユーザーがあるかチェックする
 * @returns
 */
function userIdCheck(){
	var userId = $('#userId').val();
	if(!inputDataCheck.userId(userId)) return false;
	
	$.ajax({
		type : "POST",
		url : "./userIdCheckAjax.php",
		data : {userId : userId},
		success : function(data){
			if(data){
				alert('このIDは使用できません。');
				$('#userId').val('');
				$('#userId').focus();
			}else{
				alert('このIDは使用できます。');
				userIdCheckResult = 1;
				$('#userPassword').focus();
			}
		}
	});
}


/**
 * E-メールをチェックする
 * @returns
 */
function userEmailCheck()
{
	var userEmail = $('#userEmail').val();
	if(!inputDataCheck.userEmail(userEmail)) return false;
	
	$.ajax({
		type : "POST",
		url : "../user/userEmailCheckAjax.php",
		data : {userEmail : userEmail},
		success : function(data){
			if(data){
				alert('このE-メールは使用できません。');
				$('#userEmail').val('');
				$('#userEmail').focus();
			}else{
				userEmailCheckResult = 1;
				alert('このE-メールは使用できます。');
				$('#userZipcode').focus();
			}
		}
	});
}

/**
 * 住所API
 * @returns
 */
function searchZipCode(){
	var zipCode = $('#userZipCode').val();
	if(!inputDataCheck.userZipCode(zipCode)) return false;
	
	$.ajax({
		type : "GET",
		url : "http://geoapi.heartrails.com/api/json?method=searchByPostal",
		data : {postal : zipCode},
		success : function(data){
			
			if(data['response'].error == undefined){
				var prefecture = data['response']['location'][0].prefecture;
				var city = data['response']['location'][0].city;
				var town = data['response']['location'][0].town;
				
				if(town.indexOf('町') != -1){
					$('#userAddress1').val(prefecture + " " + city + " " + town.substring(0, town.lastIndexOf('町'))+"町"); 
					$('#userAddress2').focus();
				}else{
					$('#userAddress1').val(prefecture + city); 
					$('#userAddress2').focus();
				}
			}else{
				alert('郵便番号が間違っています。');
				$('#userZipCode').val('');
				$('#userAddress1').val('');
				$('#userZipCode').focus();
			}
			
			
		}
	});
}


/**
 * ログインチェック
 * @returns
 */
function loginCheck(){
	if(!inputDataCheck.userId($('#userId').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
}
/**
 * パスワード変更
 * @returns
 */
function updatePasswordCheck(){
	if(!inputDataCheck.oldPassword($('#oldPassword').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) return false;
}

$('.ModalClose').on('click', function(){$('input').val('');});

/**
 * ユーザー詳細情報変更
 * @returns
 */
function isDetailUserUpdate(){
	var userNo = $('#userNo').val();
	var userPhoneNumber = $('#userPhoneNumber').val();
	var userEmail = $('#userEmail').val();
	var userZipCode = $('#userZipCode').val();
	var userAddress1 = $('#userAddress1').val();
	var userAddress2 = $('#userAddress2').val();
	
	if(!inputDataCheck.userPhoneNumber(userPhoneNumber)) return false;
	if(!inputDataCheck.userEmail(userEmail)) return false;
	if(!inputDataCheck.userZipCode(userZipCode)) return false;
	if(!inputDataCheck.userAddress1(userAddress1)) return false;

	$.ajax({
		type : "POST",
		url : "./detailUserUpdateAjax.php",
		data : {
			userNo : userNo,
			userPhoneNumber : userPhoneNumber,
			userEmail : userEmail,
			userZipCode : userZipCode,
			userAddress1 : userAddress1,
			userAddress2 : userAddress2
		},
		success : function(result){
			if(result){
				alert('会員情報を変更しました。');
				location.href="./detailUser.php";
			}else{
				alert('会員情報を変更できませんでした。');
			}
		}
	});
}


/**
 * 会員脱退
 * @param userNo
 * @returns
 */
function deleteUserFunction(userNo){
	if(!inputDataCheck.userDeletePassword($('#userDeletePassword').val())) return false;
	
	$.ajax({
		type : 'POST',
		url : './deleteUserAjax.php',
		data : {
			userNo : userNo,
			userPassword : $('#userDeletePassword').val()
		},
		success : function(result){
			switch(result){
				case '999':
					alert('DBエラー');
					break;
				case '9':
					alert('パスワードが間違ってます。');
					$('#userDeletePassword').val('');
					$('#userDeletePassword').focus();
					break;
				case '1' :
					alert('脱退しました。');
					location.href='../index.php';
					break;
			}
		}
	});
	
}

/**
 * ID探す
 * @returns
 */
function findUserIdAjax(){
	var userEmail = $('#findIdEmail').val();
	
	if(userEmail == ''){
		alert('E-メールを入力してください。');
		$('#findIdEmail').focus();
		return false;
	}
	
	
	$.ajax({
		type : "POST",
		url : "./findUserIdAjax.php",
		data : {userEmail : userEmail},
		success : function(result){
			if(result != ''){
				$('#findUserIdResult').html("IDは："+result+"です。");
			}else{
				$('#findUserIdResult').html("E-メールと一致するデータはありません。");
			}
			
		}
	});
	
}


/**
 * パスワード探す
 * @returns
 */
function findUserPasswordAjax(){
	var userId = $('#findPasswordId').val();
	var userEmail = $('#findPasswordEmail').val();
	
	if(userId == ''){
		alert('IDを入力してください。');
		$('#findPasswordId').focus();
		return false;
	}
	if(userEmail == ''){
		alert('E-メールを入力してください。');
		$('#findPasswordEmail').focus();
		return false;
	}
	
	$.ajax({
		type : "POST",
		url : "./findUserPasswordAjax.php",
		data : {
			userId : userId,
			userEmail : userEmail
		},
		success : function(result){
			if(result != ''){
				$('#findUserPasswordResult').html("PASSWORDは："+result+"です。");
			}else{
				$('#findUserPasswordResult').html("データと一致するデータはありません。");
			}
		}
	});
}

/**
 * ユーザー管理
 * @param userNo
 * @returns
 */
function userDetailModal(userNo){
	
	$.ajax({
		type : "POST",
		url : "../user/detailUserModal.php",
		data : {userNo : userNo},
		success : function(result){
			$('#detailUserIdModal').html(result['result']['user_id']);
			$('#detailUserNameModal').html(result['result']['user_name']);
			$('#detailUserBirthModal').html(result['result']['user_birth']);
			$('#detailUserPhoneModal').html(result['result']['user_phone']);
			$('#detailUserEmailModal').html(result['result']['user_email']);
			$('#detailUserAddressModal').html("("+result['result']['user_zipcode']+")"+ result['result']['user_address1'] + " " + result['result']['user_address2']);
			$('#detailUserCreatedateModal').html(result['result']['user_createdate']);
			$('#detailUserUpdatedateModal').html(result['result']['user_updatedate']);
			$('#detailUserDeletedateModal').html(result['result']['user_deletedate']);
			$('#detailUserLikeCountModal').html(result['result']['user_likecount']);
			$('#detailUserHateCountModal').html(result['result']['user_hatecount']);
			if(result['result']['user_deletecheck'] == '0'){
				$('#detailUserDeleteCheckModal').html('(会員)');
			}else{
				$('#detailUserDeleteCheckModal').html('(非会員)');
			}
			$('#detailUserModal').modal('show');
			
		}
	});
}

/**
 * ユーザーが登録した出品項目
 * @param userNo
 * @returns
 */
function userGoodsCountCheck(userNo){
	$.ajax({
		type : 'POST',
		url : './userGoodsCountCheckAjax.php',
		data : {userNo : userNo},
		success : function(result){
			if(result == '9') {
				alert('情報がありません。');
				return false;
			}
			$('#userGoodsCountCheckList').html('');
			$('#userGoodsCountCheckUserId').html(result['result'][0].user_id+"様の出品項目");
			
			
			for(var i = 0; i < result['result'].length; i++){
				var goodsOnSale = "<span class='text-primary'>販売中</span>";
				if(result['result'][i].goods_onsale == '1'){
					goodsOnSale = "<span class='text-danger'>販売完了</span>";
				}
				var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
				if(result['result'][i].goods_filerealname == null){
					img = '<img src="../img/noImg.jpg" style="max-height: 74px; max-width: 74px">'
				}
				
				if(result['result'][i].goods_onsale == '1'){
					img = '<img src="../img/soldout.png" style="max-height: 74px; max-width: 74px">';
				}
				$('#userGoodsCountCheckList').append(
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
						'<div style="margin: 2px; padding: 5px; flex: 0 1 20%;">' +
						'<p style="margin:0">'+goodsOnSale+'</p>' +
						'</div>' +
						'</div>' 
						);
			}
			$('#userGoodsCountCheckModal').modal('show');
			
		}
	});
	
}

/**
 * いいねボタン押すといいね表示される
 * @returns
 */
function userLikeCountButton(userNo){
	$.ajax({
		type : 'POST',
		url : '../user/likeCountAjax.php',
		data : {
			userNo : userNo
		},
		success : function(result){
			if(result == '8'){
				alert('ログインしてください。');
				return false;
			}else if(result == '9') {
				alert('一回した押せません。');
				return false;
			}
			$('#userLikeCount').html(result['result'][0].user_likecount);
			
		}
	});
}

/**
 * 悪いボタン押すと悪い表示される
 * @returns
 */
function userHateCountButton(userNo){
	$.ajax({
		type : 'POST',
		url : '../user/hateCountAjax.php',
		data : {
			userNo : userNo
		},
		success : function(result){
			if(result == '8'){
				alert('ログインしてください。');
				return false;
			}else if(result == '9') {
				alert('一回した押せません。');
				return false;
			}
			$('#userHateCount').html(result['result'][0].user_hatecount);
		}
	});
}

$('#nonUserBuyClose').click(function(){
	$('#userName').val('');
	$('#userPassword').val('');
	$('#userPasswordCheck').val('');
	$('#userEmail').val('');
	$('#userZipCode').val('');
	$('#userAddress1').val('');
	$('#userAddress2').val('');
})

function nonUserBuy(goodsNo){
	if(!inputDataCheck.userName($('#userName').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) return false;
	if(!inputDataCheck.userEmail($('#userEmail').val())) return false;
	if(!inputDataCheck.userZipCode($('#userZipCode').val())) return false;
	if(!inputDataCheck.userAddress1($('#userAddress1').val())) return false;
	
	$.ajax({
		type:'POST',
		url : '../buy/nonUserBuyAjax.php',
		data : {
			goodsNo : goodsNo,
			nonUserName : $('#userName').val(),
			nonUserPassword :$('#userPasswordCheck').val(),
			nonUserEmail : $('#userEmail').val(),
			nonUserAddress : $('#userZipCode').val() + $('#userAddress1').val() + $('#userAddress2').val()
		},
		success : function(result){
			
			if(result == '11'){
				alert('購入完了された商品です。');
			}else if(result == '1'){
				alert('購入しました。');
				location.href="../index.php";
			}
		}
	});
}

function nonUserCheck(){
	if(!inputDataCheck.userEmail($('#userEmail').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	
	$.ajax({
		type : 'POST',
		url : './nonUserBuyListAjax.php',
		data : {
			nonUserEmail : $('#userEmail').val(),
			nonUserPassword : $('#userPassword').val()
		},
		success : function(result){
			if(result == "9"){
				alert('入力した情報はありません。');
				$('#userEmail').val('');
				$('#userPassword').val('');
			}else{
				console.log(result);
				
				$('#nonUserBuyName').html(result['result'].nonuser_name+"様の購入リスト");
				$('#nonUserBuyList').append(
						'<hr>'+
						'<div style="display: flex;flex-direction: row">' +
						'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;" id="listImg">' +
						'<img src=\'../upload/'+result['result'].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">' +
						'</div>'+
						'<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">' +
						'<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no='+result['result'].goods_no+'">'+ result['result'].goods_title +'</a></h5>' +
						'<p style="margin-bottom:10px"><span class="text-dark font-weight-bold">' + result['result'].goods_price + '</span></p>' +
						'<p style="margin:0"><span class="text-dark">' + result['result'].goods_content + '</span></p>' +
						'</div>' +
						'</div>' 
						);
				$('#nonUserBuyModal').modal('show');				
			}
			
		}
	});
	
}
