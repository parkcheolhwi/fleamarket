
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
			$('#oldPassword').val('');
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
	
	
	
	
	
	
	this.findIdEmail = function(findIdEmail){
		if(findIdEmail == ''){
			alert('E-メールを入力してください。');
			$('#findIdEmail').focus();
			return false;
		}
		if(!/^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/.test(findIdEmail)){
			alert('E-メール形式が間違っています。');
			$('#findIdEmail').val('');
			$('#findIdEmail').focus();
			return false;
		}
		
		return true;
	}
	this.findPasswordId = function(findPasswordId){
		if(findPasswordId == ''){
			alert('IDを入力してください。');
			$('#findPasswordId').focus();
			return false;
		}
		if(!/^[a-zA-Z0-9]{8,16}$/.test(findPasswordId)){
			alert('8~16桁の数字と英語だけ使えます。');
			$('#findPasswordId').val('');
			$('#findPasswordId').focus();
			return false;
		}
		return true;
	}
	this.findPasswordEmail = function(findPasswordEmail){
		if(findPasswordEmail == ''){
			alert('E-メールを入力してください。');
			$('#findPasswordEmail').focus();
			return false;
		}
		if(!/^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/.test(findPasswordEmail)){
			alert('E-メール形式が間違っています。');
			$('#findPasswordEmail').val('');
			$('#findPasswordEmail').focus();
			return false;
		}
		
		return true;
	}
	
	
	

	this.goodsTitle = function(goodsTitle){
		if(goodsTitle == ''){
			alert('タイトルを入力してください。');
			$('#goodsTitle').focus();
			return false;
		}
		return true;
	}
	this.goodsPrice = function(goodsPrice){
		
		if(goodsPrice == ''){
			alert('価格を入力してください。');
			$('#goodsPrice').focus();
			return false;
		}
		if( !/^[0-9]{0,6}$/.test(goodsPrice) ) {
			alert("価格は6桁以下の数字だけ入力できます。。");
			$('#goodsPrice').val('');
			$('#goodsPrice').focus();
		}
		return true;
	}
	this.goodsContent = function(goodsContent){
		if(goodsContent == ''){
			alert('内容を入力してください。');
			$('#goodsContent').focus();
			return false;
		}
		return true;
	}

}



var userIdCheckResult = 0;
var userEmailCheckResult = 0;
/**
 * 空のデータをチェックする (/user/signup.php)
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
	var formData = $('#signupForm').serialize();
	$.ajax({
		type : 'POST',
		url : './userAjax.php',
		data : formData,
		success : function(result){
			if(result == "99"){
				alert('ID,Emailが重複されてます。やり直してください。');
			}else if(result == "1"){
				alert('会員登録に成功しました。メールから認証を行ってください。');
				location.href='./login.php';
			}
		}
	});
}

/**
 * 電話番号のinputタグが変わるとチェックする(/user/signup.php
 * 										/user/detailUser.php)
 * @returns
 */
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
 * パスワードが一致するかチェック(/user/signup.php
 * 	 							/user/detailUser.php
 * 								/user/login.php)
 * @returns
 */
$('#userPassword').change(function(){
	if(!inputDataCheck.userPassword($('#userPassword').val())) {
		return false;
	}
})

$('#userId').change(function(){
	if(!inputDataCheck.userId($('#userId').val())) {
		return false;
	}
})

/**
 * パスワード二つを比較します。(/user/signup.php
 * 							  /user/detailUser.php)
 * @returns
 */
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
 * ユーザーがあるかチェックする (/user/signup.php)
 * @returns
 */
function userIdCheck(){
	var userId = $('#userId').val();
	if(!inputDataCheck.userId(userId)) return false;
	
	$.ajax({
		type : "POST",
		url : "./userAjax.php",
		data : {
			userId : userId,
			userCmd : 'idCheck'
			},
		success : function(data){
			if(data){
				alert('このIDは使用できません。');
				$('#userId').val('');
				$('#userId').focus();
			}else{
				alert('このIDは使用できます。');
				userIdCheckResult = 1;
				$('#userId').attr("readonly",true).attr("disabled",false);
				$('#changeId').show();
				$('#userPassword').focus();
			}
		}
	});
}

$('#changeId').click(function(){
	userIdCheckResult = 0;
	$('#userId').val('');
	$('#userId').focus();
	$("#userId").attr("disabled",false).attr("readonly",false);
	$('#changeId').hide();
});


/**
 * E-メールをチェックする (/user/signup.php)
 * @returns
 */
function userEmailCheck()
{
	var userEmail = $('#userEmail').val();
	if(!inputDataCheck.userEmail(userEmail)) return false;
	
	$.ajax({
		type : "POST",
		url : "../user/userAjax.php",
		data : {
			userEmail : userEmail,
			userCmd : 'emailCheck'
			},
		success : function(data){
			if(data){
				alert('このE-メールは使用できません。');
				$('#userEmail').val('');
				$('#userEmail').focus();
			}else{
				
				userEmailCheckResult = 1;
				alert('このE-メールは使用できます。');
				$('#userEmail').attr("readonly",true).attr("disabled",false);
				$('#changeEmail').show();
				$('#userZipcode').focus();
			}
		}
	});
}

$('#changeEmail').click(function(){
	userEmailCheckResult = 0;
	$('#userEmail').val('');
	$('#userEmail').focus();
	$("#userEmail").attr("disabled",false).attr("readonly",false);
	$('#changeEmail').hide();
})

/**
 * 住所API(/user/signup.php)
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
 * ログインフォームのデータをチェック(/user/login.php)
 * @returns
 */
function loginCheck(){
	if(!inputDataCheck.userId($('#userId').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	var formData = $('#loginForm').serialize();
	$.ajax({
		type : 'POST',
		url : './userAjax.php',
		data : formData,
		success : function(result){
			if(result == "9"){
				alert('ログイン情報がありません。');
				
			}else if(result == "99"){
				alert('メールから認証を行ってください。');
			}else if(result == "1"){
				location.href="../index.php";
			}
		}
	});
	
}

/**
 * パスワード変更でデータをチェックする(/user/detailUser.php)
 * @returns
 */
function updatePasswordCheck(){
	if(!inputDataCheck.oldPassword($('#oldPassword').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) return false;
	if($('#userPassword').val() != $('#userPasswordCheck').val()){
		alert('パスワードが一致しません。');
		$('#userPassword').val('');
		$('#userPasswordCheck').val('');
		$('#userPassword').focus();
		return false;
	}
	var formData = $("#passwordUpdateForm").serialize();
	$.ajax({
		type : 'POST',
		url : './userAjax.php',
		data : formData,
		success : function(result){
			if(result == "9"){
				alert('旧パスワードが間違ってます。');
				$('#oldPassword').focus();
			}else if(result =="1"){
				alert('パスワード変更に成功しました。再ログインしてください。');
				location.href='../index.php';
			}
		}
	});
}


/**
 * ユーザー詳細情報変更(/user/detailUser.php)
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
		url : "./userAjax.php",
		data : {
			userNo : userNo,
			userPhoneNumber : userPhoneNumber,
			userEmail : userEmail,
			userZipCode : userZipCode,
			userAddress1 : userAddress1,
			userAddress2 : userAddress2,
			userCmd : 'updateUser'
		},
		success : function(result){
			if(result == "999"){
				alert('Emailは使用されてます。他のメールを入力してください。');
				$('#userEmail').val('');
				$('#userEmail').focus();
			}else if(result == "1"){
				alert('会員情報を変更しました。');
				location.href="./detailUser.php";
			}else{
				alert('会員情報を変更できませんでした。');
			}
		
		}
	});
}


/**
 * 会員脱退(/user/detailUser.php)
 * @param userNo
 * @returns
 */
function deleteUserFunction(userNo){
	if(!inputDataCheck.userDeletePassword($('#userDeletePassword').val())) return false;
	
	$.ajax({
		type : 'POST',
		url : './userAjax.php',
		data : {
			userNo : userNo,
			userPassword : $('#userDeletePassword').val(),
			userCmd : 'deleteUser'
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
 * ID探す(/user/login.php)
 * @returns
 */
function findUserIdAjax(){
	var userEmail = $('#findIdEmail').val();
	if(!inputDataCheck.findIdEmail(userEmail)) return false;
	
	$.ajax({
		type : "POST",
		url : "./userAjax.php",
		data : {
			userEmail : userEmail,
			userCmd : 'findId'
			},
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
 * パスワード探す(/user/login.php)
 * @returns
 */
var findUserPassword = new function(){
	
	this.findUserPasswordAjax = function(){
		
		var userId = $('#findPasswordId').val();
		var userEmail = $('#findPasswordEmail').val();
		
		if(!inputDataCheck.findPasswordId(userId)) return false;
		if(!inputDataCheck.findPasswordEmail(userEmail)) return false;
		
		$.ajax({
			type : "POST",
			url : "./userAjax.php",
			data : {
				userId : userId,
				userEmail : userEmail,
				userCmd : 'findPassword'
			},
			success : function(result){
				if(result == "999"){
					alert("DB接続エラー");
				}else if (result == "9"){
					alert('一致するデータはありません。');
				}else if(result == "1"){
					alert('メールに認証番号を送りしました。');
					$('#passwordSearch1').hide();
					$('#passwordSearch2').show();
					$('#findPasswordIdhidden').val(userId);
				}
			}
		});
	}
	
	this.certificationNumberCheck = function(){
		var certificationNumber = $('#certificationNumber').val();
		$.ajax({
			type : 'POST',
			url : './userAjax.php',
			data : {
				certificationNumber : certificationNumber,
				userCmd : 'certificationNumberCheck'
				},
			success : function(result){
				if(result == "99"){
					alert('認証番号を確認してください。');
					$('#certificationNumber').val('');
					$('#certificationNumber').focus();
				}else if(result == "1"){
					alert('認証番号を確認しました。');
					$('#findUserPassword').modal('hide');
					$('#newPasswordInsert').modal('show');
				}
				
			}
		});
	}
	
	this.newIdPasswordUpdate = function(){
		if($('#newUserPassword').val() == ''){
			alert('パスワードを入力してください。');
			$('#newUserPassword').focus();
			return false;
		}
		if($('#newUserPasswordCheck').val() == ''){
			alert('パスワードを入力してください。');
			$('#newUserPasswordCheck').focus();
			return false;
		}
		if($('#newUserPassword').val() != $('#newUserPasswordCheck').val()){
			alert('パスワードが一致しません。');
			$('#newUserPassword').val('');
			$('#newUserPasswordCheck').val('');
			$('#newUserPassword').focus();
			return false;
		}
		var userPassword = $('#newUserPasswordCheck').val();
		var userId = $('#findPasswordIdhidden').val();

		$.ajax({
			type : 'POST',
			url : './userAjax.php',
			data : {
				userId : userId,
				userPassword : userPassword,
				userCmd : 'newPassword'
			},
			success : function(result){
				if(result == "999"){
					alert('失敗しました。');
					$('#newPasswordInsert').modal('hide');
				}else if(result == "1"){
					alert('パスワード更新しました。ログインしてください。');
					location.href="./login.php";
				}
			}
		});
	}
}



/**
 * ユーザー管理(/user/listUser.php)
 * @param userNo
 * @returns
 */
function userDetailModal(userNo){
	$.ajax({
		type : "POST",
		url : "../user/userAjax.php",
		data : {
			userNo : userNo,
			userCmd : 'userModal'
			},
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
 * ユーザーが登録した出品項目(/user/listUser.php)
 * @param userNo
 * @returns
 */
function userGoodsCountCheck(userNo){
	$.ajax({
		type : 'POST',
		url : './userAjax.php',
		data : {
			userNo : userNo,
			userCmd : 'goodsCountCheck'
			},
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
					img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">'
				}
				
				if(result['result'][i].goods_onsale == '1'){
					img = '<img src="../upload/soldout.png" style="max-height: 74px; max-width: 74px">';
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
 * いいねボタン押すといいね表示される(/goods/goodsDetail.php)
 * @returns
 */
function userLikeCountButton(userNo){
	$.ajax({
		type : 'POST',
		url : '../user/userAjax.php',
		data : {
			userNo : userNo,
			userCmd : 'likeCount'
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
 * 悪いボタン押すと悪い表示される(/goods/goodsDetail.php)
 * @returns
 */
function userHateCountButton(userNo){
	$.ajax({
		type : 'POST',
		url : '../user/userAjax.php',
		data : {
			userNo : userNo,
			userCmd : 'hateCount'
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





/**
 * 商品登録Modalを表示する(/goods/goodsList.php)
 * @returns
 */
function openGoodsInsertModal(){
	$('#goodsInsertModal').modal('show');
}


/**
 * 登録して表示する(goods/goodsList.php)
 * @returns
 */
function goodsInsert(){
	var goodsTitle = $('#goodsTitle').val();
	var goodsPrice = $('#goodsPrice').val();
	var goodsContent = $('#goodsContent').val();
	
	if(!inputDataCheck.goodsTitle(goodsTitle)) return false;
	if(!inputDataCheck.goodsPrice(goodsPrice)) return false;
	if(!inputDataCheck.goodsContent(goodsContent)) return false;
	
	var formData = new FormData($("#goodsInsertForm")[0]);
	
	$.ajax({
		type : 'POST',
		url : "./goodsAjax.php",
		processData: false, 
		contentType: false,
		data : formData,
		success : function(result){	
			var img = '<img src=\'../upload/'+result['result'].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
			var button = '<button type="button" class="btn btn-info btn-sm" onclick="insertIntoCart(\''+result['result'].goods_no+'\')" >カートに入れる</button>';
			if(result['result'].goods_filerealname == null){img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">';}
			if(result['result'].goods_onsale == '1'){img = '<img src="../upload/soldout.png" style="max-height: 74px; max-width: 74px">';}
			if (result['userAuthority'] == "9"){
				if(result['result'].goods_onsale == '1' && result['result'].goods_commission == '1'){ 
					button = '<button type="button" class="btn btn-danger btn-sm" onclick="#" >要請完了</button>';
				}else if(result['result'].goods_onsale == '1' && result['result'].goods_commission == '0') {
					button = '<button type="button" class="btn btn-success btn-sm" onclick="commissionCreate(\''+result['result'].goods_no+'\')" >手数料要請</button>';
				}else{
					button ="";
				}
			} else{
				if(result['result'].goods_onsale == '1')	button = "";
			}
			$('#goodsDiv').prepend(
					'<hr>'+
					'<div style="display: flex;flex-direction: row">' +
					'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">' +
					img +
					'</div>'+
					'<div style="margin: 2px; padding: 5px; flex: 0 1 70%;">' +
					'<h5 style="margin:0" class="text-dark font-weight-bold"><a href="./goodsDetail.php?goods_no='+result['result'].goods_no+'" >'+ result['result'].goods_title +'</a></h5>' +
					'<p style="margin-bottom:10px"><span class="text-dark font-weight-bold">' + result['result'].goods_price + '円</span></p>' +
					'<p style="margin:0"><span class="text-dark">' + result['result'].goods_content + '</span></p>' +
					'</div>' +
					'<div style="margin: 2px; padding: 5px; flex: 0 1 20%;">' +
					'<p style="margin:0">修正日：' + result['result'].goods_updatedate + '</p>' +
					'<p style="margin-bottom:10px">登録日：' + result['result'].goods_createdate+ '</p>' +
					'<p style="margin:0">'+button+'</p>' +
					'</div>' +
					'</div>' 
					);
			location.href="./goodsList.php";
		}
	});
}


/**
 * 検索する(/goods/goodsLIst.php)
 * @returns
 */
var goodsArea = '';
$("#goodsAreaSelect").change(function(){
	goodsArea = $(this).val();
	goodsAllList();
})

/**
 * 全ての商品情報を表示する(goods/goodsList.php)
 * @returns
 */
function goodsAllList(){
	
	var searchGoods = $('#goodsSearch').val();
	if(goodsArea != '') goodsArea = goodsArea;
	
	$.ajax({
		type : 'POST',
		url : "./goodsAjax.php",
		data : {
			searchGoods : searchGoods,
			goodsArea : goodsArea,
			goodsCmd : 'list'
			},
		success : function(result){
			$('#goodsDiv').html('');	
			goodsDivAppend(result);
		}
	});
}

/**
 * 商品リスト表示する(/goods/goodsList.php)
 * @param result
 * @returns
 */
function goodsDivAppend(result){
	var listData = "";
	for(var i = 0; i < result['result'].length; i++){
		/* 条件によって写真が変わる */
		var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
		var button = '<button type="button" class="btn btn-info btn-sm" onclick="insertIntoCart(\''+result['result'][i].goods_no+'\')" >カートに入れる</button>';
		if(result['result'][i].goods_filerealname == null){img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">'}
		if(result['result'][i].goods_onsale == '1'){img = '<img src="../upload/soldout.png" style="max-height: 74px; max-width: 74px">';}

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

		listData = listData +
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
				'</div>';
	}
	$('#goodsDiv').html(listData)
}
/**
 * 手数料要請する(/goods/goodsList.php)
 * @param goodsNo
 * @returns
 */
function commissionCreate(goodsNo){
	$.ajax({
		type : 'POST',
		url : './goodsAjax.php',
		data : {
			goodsNo : goodsNo,
			goodsCmd :'commissionCreate'
			},
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
 * 削除確認Modalを表示する(goods/goodsdetail.php)
 * @returns
 */
function goodsDeleteModal(){$('#goodsDeleteModal').modal('show');}
/**
 * パスワード確認後データを削除する(goods/goodsdetail.php)
 * @returns
 */
function goodsDelete(){
	var goodsNo = $('#goodsNo').val();
	var userPassword = $('#goodsDeleteForm [name="userPassword2"]').val();
	
	$.ajax({
		type : 'POST',
		url : './goodsAjax.php',
		data : {
			goodsNo : goodsNo,
			userPassword : userPassword,
			goodsCmd : 'delete'
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
 * 商品更新MODALを表示する(goods/goodsdetail.php)
 * @returns
 */
function goodsUpdateModal(){
	$('#goodsUpdateModal').modal('show');
}

/**
 * データを更新する(goods/goodsdetail.php)
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
	if( !/^[0-9]{0,6}$/.test($('#goodsUpdateForm [name="goodsPrice"]').val()) ) {
		alert("価格は6桁以下の数字だけ入力できます。。");
		$('#goodsUpdateForm [name="goodsPrice"]').val('');
		$('#goodsUpdateForm [name="goodsPrice"]').focus();
		return false;
	}
	if($('#goodsUpdateForm [name="goodsContent"]').val() == ''){
		alert('内容を入力してください。');
		$('#goodsUpdateForm [name="goodsContent"]').focus();
		return false;
	}
	var formData = new FormData($("#goodsUpdateForm")[0]);
	$.ajax({
		type : 'POST',
		url : './goodsAjax.php',
		processData: false, 
		contentType: false,
		data : formData,
		success : function(result){
			if(result == "1"){
				alert('更新しました。');
				location.href='./goodsDetail.php?goods_no='+$('#goodsUpdateForm [name="goodsNo"]').val();
			}else if (result == "999"){
				alert('失敗しました。');
			}else if(result == "9"){
				alert('販売完了された商品は修正できませ。');
			}
		}
	});
}

	
/**
 * コメント管理(goods/goodsdetail.php)
 */
var commentManager = new function(){
	
	/**
	 * コメント登録する
	 */
	this.insert= function(data){
		var goodsNo = $('#goodsNo').val();
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
			url : "./commentAjax.php",
			data : {
				goodsNo : goodsNo,
				goodsCommentContent : goodsCommentContent,
				userNo : userNo,
				commentCmd : 'insert'
			},
			success : function(result){	
				if(result){
					$('#goodsCommentContent').val('');
					commentManager.list(goodsNo, userNo);
				}else{
					alert('エラー');
				}
			}
		});
	}
	
	this.deleteFunction = function(goodsNo, commentNo){
		$.ajax({
			type : 'POST',
			url : './commentAjax.php',
			data : {
				goodsNo : goodsNo,
				commentNo : commentNo,
				commentCmd : 'delete'
				},
		success : function(result){commentManager.list(goodsNo, result);}
		});
	}
	
	this.list = function(goodsNo, userNo){
		$.ajax({
			type : 'POST',
			url : "./commentAjax.php",
			data : {
				goodsNo : goodsNo,
				commentCmd : 'list'
			},
			success : function(result){

				$('#goodsCommentList').html('');
				$('#goodsCommentForm [name="goodsCommentContent"]').val('');
				for(var i = 0; i < result['result'].length; i++){
					var deleteButton = "";
					var updateButton = "";
					if(result['result'][i].user_no == jQuery.trim(userNo)){
						deleteButton ='<span style="float:right;" id="commentDeleteButton'+result['result'][i].goods_comment_no+'" ><a href="javascript:void(0);" onclick="commentManager.deleteFunction(\''+result['result'][i].goods_no+'\', \''+result['result'][i].goods_comment_no+'\')">削除</a></span>';
						updateButton = '<span style="float:right; margin-right:10px" id="commentUpdateButton'+result['result'][i].goods_comment_no+'"><a href="javascript:void(0);" onclick="commentManager.updateForm(\''+result['result'][i].goods_comment_content+'\', \''+result['result'][i].goods_comment_no+'\')">修正</a></span>';
					}
					$('#goodsCommentList').append(
							'<hr style="margin-top:30px; margin-bottom:0px; clear:both;">' +
							'<div>' +
							'<span style="float:left">'+result['result'][i].user_id+'</span>' +
							'<span style="float:right">'+result['result'][i].goods_comment_createdate+'</span>' +
							'</div>' +
							'<div style="clear:both"></div>' +
							'<div>'+
							'<span style="float:left; width:90%" id="comment'+result['result'][i].goods_comment_no+'">' +result['result'][i].goods_comment_content+'</span>' +
							 deleteButton + 
							 updateButton +
							'</div>'
							);
				}
			}
		});
	}
	
	this.updateForm = function(commentContent, commentNo){
		var textarea = '<textarea class="form-control" id="commentContentUpdate" name="commentContentUpdate" rows="2">'+commentContent+'</textarea>';
		$('#comment'+commentNo).html(textarea);
		
		$('#commentDeleteButton'+commentNo).html('<a href="javascript:void(0)" onclick="commentManager.updateCancel(\''+commentContent+'\', \''+commentNo+'\')">取消</a>');
		$('#commentUpdateButton'+commentNo).html('<a href="javascript:void(0);" onclick="commentManager.updateComment('+commentNo+')">修正</a>');
	}
	
	var goodsNo = $('#goodsNo').val();
	this.updateCancel = function(commentContent, commentNo){
		$('#comment'+commentNo).html(commentContent);
		$('#commentDeleteButton'+commentNo).html('<a href="javascript:void(0);" onclick="commentManager.deleteFunction(\''+goodsNo+'\', \''+commentNo+'\')">削除</a>');
		$('#commentUpdateButton'+commentNo).html('<a href="javascript:void(0);" onclick="commentManager.updateForm(\''+commentContent+'\', \''+commentNo+'\')">修正</a>');
	}
	
	this.updateComment = function(commentNo){
		$.ajax({
			type : 'POST',
			url : './commentAjax.php',
			data : {
				goodsCommentContent : $('#commentContentUpdate').val(),
				commentNo : commentNo,
				commentCmd : 'update'
			},
			success : function(result){
				if(result){
					$('#comment'+commentNo).html(result['result'].goods_comment_content);
					$('#commentDeleteButton'+commentNo).html('<a href="javascript:void(0);" onclick="commentManager.deleteFunction(\''+goodsNo+'\', \''+commentNo+'\')">削除</a>');
					$('#commentUpdateButton'+commentNo).html('<a href="javascript:void(0);" onclick="commentManager.updateForm(\''+result['result'].goods_comment_content+'\', \''+commentNo+'\')">修正</a>');
				}else{
					alert('コメント修正失敗しました。');
				}
			}
		});
	}
}




















/**
 * 非会員購入(/goods/goodsDetail.php)
 * @param goodsNo
 * @returns
 */
function nonUserBuy(goodsNo){
	if(!inputDataCheck.userName($('#userName').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	if(!inputDataCheck.userPasswordCheck($('#userPasswordCheck').val())) return false;
	if(!inputDataCheck.userEmail($('#userEmail').val())) return false;
	if(!inputDataCheck.userZipCode($('#userZipCode').val())) return false;
	if(!inputDataCheck.userAddress1($('#userAddress1').val())) return false;
	
	$.ajax({
		type:'POST',
		url : '../buy/buyAjax.php',
		data : {
			goodsNo : goodsNo,
			nonUserName : $('#userName').val(),
			nonUserPassword :$('#userPasswordCheck').val(),
			nonUserEmail : $('#userEmail').val(),
			nonUserAddress : $('#userZipCode').val() + $('#userAddress1').val() + $('#userAddress2').val(),
			buyCmd : 'nonUserBuy'
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


/**
 * 非会員の情報をチェックする(/buy/nonUser.php)
 * @returns
 */
function nonUserCheck(){
	if(!inputDataCheck.userEmail($('#userEmail').val())) return false;
	if(!inputDataCheck.userPassword($('#userPassword').val())) return false;
	
	$.ajax({
		type : 'POST',
		url : './buyAjax.php',
		data : {
			nonUserEmail : $('#userEmail').val(),
			nonUserPassword : $('#userPassword').val(),
			buyCmd : 'nonUserBuyList'
		},
		success : function(result){
			if(result == "9"){
				alert('入力した情報はありません。');
				$('#userEmail').val('');
				$('#userPassword').val('');
			}else{
				var img = '<img src=\'../upload/'+result['result'].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
				if(result['result'].goods_filerealname == null){img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">';}
				$('#nonUserBuyName').html(result['result'].nonuser_name+"様の購入リスト");
				$('#nonUserBuyList').append(
						'<hr>'+
						'<div style="display: flex;flex-direction: row">' +
						'<div style="margin: 2px; padding: 5px; flex: 0 1 10%;" id="listImg">' +
						img +
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

/**
 * 商品を購入する
 * (
 * buy/cartList.php
 * goods/goodsDetail.php
 * )
 * @returns
 */
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
		url : '../buy/buyAjax.php',
		data : {
				goodsNo : goodsNo,
				buyCmd : 'insert'
				},
		success : function(result){
			if(result == '11'){
				alert('購入完了された商品です。');
			}else if(result == '8'){
				alert('ログインしてください。');
			}else if(result == '1'){
				alert('購入しました。');
				location.href="../buy/buyList.php";
			}else if (result == '9'){
				alert('購入に失敗しました。');
			}
		}
	});
}








/**
 * カートに登録する
 * 	(
 * 	/goods/goodsDetail.php
 * 	fleamarket.js => goodsDivAppend()
 * 	)
 * @returns
 */
function insertIntoCart(goodsNo){
	$.ajax({
		type : 'POST',
		url : '../cart/cartAjax.php',
		data : {
			goodsNo : goodsNo,
			cartCmd : 'insert'
			},
		success : function(result){
			if(result =='8'){
				alert('ログインしてください。');
			}else if(result =='11'){
				alert('販売完了された商品です。');
			}else if(result == '22'){
				alert('同じ商品が存在します。');
			}else if (result == '9'){
				alert('失敗しました。');				
			}else if (result == '1'){
				alert('登録しました。');				
			}
			
		}
	});
	
}

/**
 * 該当するカート内訳を削除する(/buy/cartList.php)
 * @param cartNo
 * @returns
 */
function cartDelete(cartNo){
	$.ajax({
		type : 'POST',
		url : './cartAjax.php',
		data : {
			cartNo : cartNo,
			cartCmd : 'delete'
			},
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
 * チェックボックスによって購入するリストを表示する(buy/cartList.php)
 * @returns
 */
function buyInsertCheck(){
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
		url : '../cart/cartAjax.php',
		data : {
			goodsNo:goodsNo,
			cartCmd : 'buyCheck'
			},
		success : function(result){
			$('#cartBuyCheckList').html('');
			for(var i = 0; i < result['result'].length; i++){
				var img = '<img src=\'../upload/'+result['result'][i].goods_filerealname+'\' style="max-height: 74px; max-width: 74px">'
				if(result['result'][i].goods_filerealname == null){
					img = '<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">'
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










/**
 * 一般ユーザーのお問い合わせする(/inquiry/inquiry.php)
 * @returns
 */
function insertInquiry(){
	
	if($('#inquiryTitle').val() == ''){
		alert('タイトルを入力してください。');
		$('#inquiryTitle').focus();
		return false;
	}
	if($('#inquiryContent').val() == ''){
		alert('内容を入力してください。');
		$('#inquiryContent').focus();
		return false;
	}
	
	var formData = $("#insertInquiryForm").serialize();
	$.ajax({
		type : 'POST',
		url : './inquiryAjax.php',
		data : formData,
		success : function(result){
			if(result){
				alert('お問い合わせしました。');
				location.href='./inquiry.php';
			}else{
				alert('失敗しました。');
				location.href='../index.php';
			}
		}
	});
}

/**
 * お問い合わせの詳細情報をMODALとして表示する(/inquiry/inquiry.php)
 * @param inquiryNo
 * @returns
 */
function inquiryModal(inquiryNo){

	$.ajax({
		type : "POST",
		url : "http://localhost:8712/fleamarket_parkcheolhwi/inquiry/inquiryAjax.php",
		data : {
			inquiryNo : inquiryNo,
			inquiryCmd : 'detail'
			},
		success : function(result){
			
			$('#myModalLabel').html(result['result']['inquiry_title']);
			$('#myModalContent').html(result['result']['inquiry_content']);
			
			if(result['result']['inquiry_replycheck'] == '0'){
				$('#inquiryNo').val(result['result']['inquiry_no']);
				$('#myModalReplyContent').html('まだ返信されてないです。');
				$('#myModalReplyContentText').html('<textarea class="md-textarea form-control" rows="3" id="inquiry_replycontent" name="inquiry_replycontent"></textarea>');
				$('#myModalReplyDate').html('');
			}else{				
				$('#inquiryNo').val(result['result']['inquiry_no']);
				$('#myModalReplyContentText').html(result['result']['inquiry_replycontent']);
				$('#myModalReplyContent').html(result['result']['inquiry_replycontent']);
				$('#myModalReplyDate').html(result['result']['inquiry_replydate']);
			}
			$('#centralModalSm').modal("show");
		}
	});  
}

/**
 * 返信する関数(/inquiry/inquiry.php)
 * @returns
 */
function inquiryReplyContent(){
	var inquiryNo = $('#inquiryNo').val();
	var myModalReplyContent = $('#inquiry_replycontent').val();
	if(myModalReplyContent == ''){
		alert('内容を入力してください。');
		$('#inquiry_replycontent').focus();
		return false;
	}
	$.ajax({
		type : "POST",
		url : "http://localhost:8712/fleamarket_parkcheolhwi/inquiry/inquiryAjax.php",
		data :{
			inquiryNo : inquiryNo,
			replyContent : myModalReplyContent,
			inquiryCmd : 'reply'
		},
		success : function(result){
			if(result){
				alert('返信しました。');
				location.href="http://localhost:8712/fleamarket_parkcheolhwi/inquiry/inquiry.php";
			}else{
				alert('返信に失敗しました。');
			}
			
		}
	});

}





/**
 * MOdalを閉じるとデータが削除される
 * @returns
 */
$(".modal").on("hidden.bs.modal", function(){
	$(".modal input").val('');
	$(".modal textarea").val('');
	
	$('#passwordSearch2').hide();
});


