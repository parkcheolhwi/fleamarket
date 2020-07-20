var userIdCheckResult = 0;
var userEmailCheckResult = 0;
/**
 * 空のデータをチェックする
 * @returns
 */
function emptyCheck() {
	if($('#userId').val() == ''){
		alert('IDを入力してください。');
		$('#userId').focus();
		return false;
	}
	if($('#userPassword').val() == ''){
		alert('パスワードを入力してください。');
		$('#userPassword').focus();
		return false;
	}
	if($('#userPasswordCheck').val() == ''){
		alert('パスワードを入力してください。');
		$('#userPasswordCheck').focus();
		return false;
	}
	if($('#userName').val() == ''){
		alert('名前を入力してください。');
		$('#userName').focus();
		return false;
	}
	if($('#year').val() == '' || $('#month').val() == '' || $('#day').val() == ''){
		alert('生年月日を入力してください。');
		$('#year').focus();
		return false;
	}
	if($('#userPhoneNumber').val() == ''){
		alert('電話番号を入力してください。');
		$('#userPhoneNumber').focus();
		return false;
	}
	if($('#userEmail').val() == ''){
		alert('E-メールを入力してください。');
		$('#userEmail').focus();
		return false;
	}
	if($('#userZipCode').val() == ''){
		alert('郵便番号を入力してください。');
		$('#userZipCode').focus();
		return false;
	}
	if($('#userAddress1').val() == ''){
		alert('住所を入力してください。');
		$('#userAddress1').focus();
		return false;
	}
	if(userIdCheckResult == 0 || userEmailCheckResult == 0){
		alert('ID, Emailをチェックしてください。');
		return false;
	}
	
}

/**
 * パスワードが一致するかチェック
 * @returns
 */
$('#userPasswordCheck').keyup(function(){
	if($('#userPassword').val() == $('#userPasswordCheck').val()){
		$('#passwordCheckResult').html('パスワードが一致します。');
		$('#passwordCheckResult').css('color', 'blue');
	}else{
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
	if(userId == ''){
		alert('IDを入力してください。');
		$('#userId').focus();
		return false;
	}
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
 * E-メールの形をチェックする
 * @param str
 * @returns
 */
function emailTypeCheck(str)
{                                                 
     var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
     if(!reg_email.test(str)) {
          return false;
     }
     else {
          return true; 
     }
}         


/**
 * E-メールをチェックする
 * @returns
 */
function userEmailCheck()
{
	var userEmail = $('#userEmail').val();
	if(userEmail == ''){
		alert('E-メールを入力してください。');
		$('#userEmail').focus();
		return false;
	}
	
	if(!emailTypeCheck(userEmail)){
		alert('E-メール形式が間違っています。');
		$('#userEmail').focus();
		return false;
	}
	
	$.ajax({
		type : "POST",
		url : "./userEmailCheckAjax.php",
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
	
	if(zipCode == ''){
		alert('郵便番号を入力してください。');
		$('#userZipCode').focus();
		return false;
	}
	
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



/*--------------------------------------ログイン-------------------------------------*/
function loginCheck(){
	if($('#userId').val() == ''){
		alert('IDを入力してください。');
		$('#userId').focus();
		return false;
	}
	if($('#userPassword').val() == ''){
		alert('PASSWORDを入力してください。');
		$('#userPassword').focus();
		return false;
	}
}


/*--------------------------------------パスワード変更-------------------------------------*/


function updatePasswordCheck(){
	
	if($('#oldPassword').val() == ''){
		alert('旧パスワードを入力してください。');
		$('#oldPassword').focus();
		return false;
	}
	if($('#newPassword1').val() == ''){
		alert('新パスワードを入力してください。');
		$('#newPassword1').focus();
		return false;
	}
	if($('#newPassword2').val() == ''){
		alert('新パスワード（確認）を入力してください。');
		$('#newPassword2').focus();
		return false;
	}
	if($('#newPassword1').val() != $('#newPassword2').val()){
		alert('新パスワードが一致しません。');
		$('#newPassword1').val('');
		$('#newPassword2').val('');
		$('#passwordCheckResult').val('');
		$('#newPassword1').focus();
		return false;
	}
    
}

$('#newPassword2').keyup(function(){
	if($('#newPassword1').val() == $('#newPassword2').val()){
		$('#passwordCheckResult').html('パスワードが一致します。');
		$('#passwordCheckResult').css('color', 'blue');
	} else{
		$('#passwordCheckResult').html('パスワードが一致しません。');
		$('#passwordCheckResult').css('color', 'red');
	}
})

$('.passwordUpdateModalClose').on('click', function(){
	$('#oldPassword').val('');
	$('#newPassword1').val('');
	$('#newPassword2').val('');
	$('#passwordCheckResult').val('');
})

/* ---------------------------------詳細情報更新---------------------------------------- */

function isDetailUserUpdate(){
	var userNo = $('#userNo').val();
	var userPhoneNumber = $('#userPhoneNumber').val();
	var userEmail = $('#userEmail').val();
	var userZipCode = $('#userZipCode').val();
	var userAddress1 = $('#userAddress1').val();
	var userAddress2 = $('#userAddress2').val();
	
	if(userPhoneNumber == ''){
		alert('電話番号を入力してください。');
		$('#userPhoneNumber').focus();
		return false;
	}
	if(userEmail == ''){
		alert('E-メールを入力してください。');
		$('#userEmail').focus();
		return false;
	}
	if(userZipCode == ''){
		alert('郵便番号を入力してください。');
		$('#userZipCode').focus();
		return false;
	}
	if(userAddress1 == ''){
		alsert('住所を入力してください。');
		$('#userAddress1').focus();
		return false;
	}
	
	
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

/* ---------------------------------会員脱退---------------------------------------- */

function deleteUser(){
	if($('#userPassword').val() == ''){
		alert('パスワードを入力してください。');
		$('#userPassword').focus();
		return false;
	}
	
	
}

/*-------------------------------------ID探す---------------------------------------------------- */
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

/*-------------------------------------PASSWORD探す---------------------------------------------------- */

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

/*---------------------ユーザー管理----------------------------- */
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
			
			var goodsOnSale = "<span class='text-primary'>販売中</span>";
			
			for(var i = 0; i < result['result'].length; i++){
				if(result['result'][i].goods_onsale == '1'){
					goodsOnSale = "<span class='text-danger'>販売完了</span>";
				}
				$('#userGoodsCountCheckList').append(
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

