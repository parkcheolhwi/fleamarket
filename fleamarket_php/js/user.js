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
		url : "./userIdCheck.php",
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
		url : "./userEmailCheck.php",
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
