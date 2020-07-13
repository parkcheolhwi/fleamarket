<?php use PHPMailer\PHPMailer\PHPMailer;?>
<?php 
if(isset($_POST['insertUser'])){
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
    
    /**
     * POST形で渡されたデータを取得する
     * @var array $singupData
     */
    $singupData = array(
        'userId' => mysqli_real_escape_string($conn, $_POST['userId']),
        'userPassword' => mysqli_real_escape_string($conn, $_POST['userPassword']),
        'userName' => mysqli_real_escape_string($conn, $_POST['userName']),
        'userBirthDay' => mysqli_real_escape_string($conn, $_POST['year']."-".$_POST['month']."-".$_POST['day']),
        'userPhoneNumber' => mysqli_real_escape_string($conn, $_POST['userPhoneNumber']),
        'userEmail' => mysqli_real_escape_string($conn, $_POST['userEmail']),
        'userZipcode' => mysqli_real_escape_string($conn, $_POST['userZipCode']),
        'userAddress1' => mysqli_real_escape_string($conn, $_POST['userAddress1']),
        'userAddress2' => mysqli_real_escape_string($conn, $_POST['userAddress2']),
        'userMailCheck' => mt_rand(100000, 999999)
    );
    
    $sql = "
        SELECT * 
            FROM userinfo
            WHERE 
                user_id = '{$singupData['userId']}'
                AND user_email = '{$singupData['userEmail']}'
                AND user_deletecheck = '0' 
        ";
    
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        mysqli_free_result($result);
        mysqli_close($conn);
        $errorMsg = "ID,Emailが重複されてます。やり直してください。";
        header("Location: ./login.php?errorMsg={$errorMsg}");
        exit;
    }
    
    # 実行するSQL文
    $sql = "
        INSERT INTO userinfo 
        (
        user_no, 
        user_id, 
        user_password, 
        user_name, 
        user_birth,    
        user_phone, 
        user_email, 
        user_zipcode,
        user_address1,
        user_address2, 
        user_createdate,
        user_mailcheck
        ) 
        VALUES
        (
        NULL,
        '{$singupData['userId']}',
        '{$singupData['userPassword']}',
        '{$singupData['userName']}',
        '{$singupData['userBirthDay']}',
        '{$singupData['userPhoneNumber']}',
        '{$singupData['userEmail']}',
        '{$singupData['userZipcode']}',
        '{$singupData['userAddress1']}',
        '{$singupData['userAddress2']}',
        NOW(),
        '{$singupData['userMailCheck']}'
        )";
    
    /**
     * SQLQuery実行確認
     */
    if(!mysqli_query($conn, $sql)){
        $errorMsg = "SQL実行に失敗しました。";
        $path = "index";
        header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
        exit;
    }
    
    /**
     * メール送信
     */
    $mailTitle = "会員登録しました。";
    $mailContent = "<html><body>{$singupData['userId']}様。<br><br>";
    $mailContent .= "会員登録ありがとうございます。<br> 以下のURLで認証を行ってください。<br><br>";
    $mailContent .= "<a href='http://localhost:8712/fleamarket_php/user/insertUserCheck.php?userId={$singupData['userId']}&num={$singupData['userMailCheck']}'>認証する</a>";    
    
    require_once '../PHPMail/PHPMailer.php';
    require_once '../PHPMail/SMTP.php';
    require_once '../PHPMail/Exception.php';
    
    $mail = new PHPMailer();
    
    #smtp setting
    $mail -> isSMTP();
    $mail -> Host= "smtp.gmail.com";
    $mail -> SMTPAuth = true;
    $mail -> Username = "parktest9999@gmail.com";
    $mail -> Password = "srlsl8183";
    $mail -> Port = 465;
    $mail -> SMTPSecure = "ssl";
    
    #送る先
    $mail ->CharSet = "UTF-8";
    $mail ->isHTML(true);
    $mail ->setFrom("{$singupData['userEmail']}", "{$singupData['userId']}");
    $mail ->addAddress("parktest9999@gmail.com"); #私のemail
    $mail ->Subject = $mailTitle;
    $mail ->Body = $mailContent;
    
    if($mail -> send()){
        mysqli_close($conn);
        $successMsg = "会員登録に成功しました。メールから認証を行ってください。";
        header("Location: ../index.php?successMsg={$successMsg}");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>会員登録 | フリマシステム</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/user.css">


</head>
<body>
	
	<?php require_once '../menu/menunav.php';?>
	<div class="row">
    	<div class="col-lg-4"></div>	
    		
    	<div class="col-lg-4">
    		<h3 style="text-align:center">会員登録</h3>
    		<form class="form-group" action="./signup.php" method="post" onsubmit="return emptyCheck()">
        		<table class="table table-borderless">
        			<tr>
        				<th>ID：</th>
        				<td class="form-inline">
        					<input class="form-control col-sm-8" type="text" id="userId" name="userId" placeholder="IDを入力してください。">&nbsp;
        					<button type="button" class="btn btn-default" onclick="userIdCheck();">重複チェック</button>
        				</td>
        			</tr>
        			<tr>	
        				<th>パスワード：</th>
        				<td><input class="form-control" type="password" id="userPassword" name="userPassword" placeholder="PassWordを入力してください。"></td>
        			</tr>
        			<tr>	
        				<th>パスワード(確認)：</th>
        				<td>
        					<input class="form-control" type="password" id="userPasswordCheck" name="userPasswordCheck" placeholder="PassWordを入力してください。">
        					<span id="passwordCheckResult"></span>
        				</td>
        			</tr>
        			<tr>	
        				<th>名前：</th>
        				<td><input class="form-control" type="text" id="userName" name="userName" placeholder="名前を入力してください。"></td>
        			</tr>
        			<tr>	
        				<th>生年月日：</th>
        				<td class="form-inline">
        					<select class="form-control" id="year" name="year">
        						<option value="">年</option>        						
        						<?php for($i = date('Y', time()); $i >= date('Y', time())-100; $i--){ ?>
            					<option value="<?=$i ?>"><?=$i ?></option>
        						<?php }	?>
        					</select>&nbsp;年&nbsp;&nbsp;
        					<select class="form-control" id="month" name="month">
								<option value="">月</option>        						
        						<?php for($i = 1; $i <= 12; $i++){ ?>
            					<option value="<?=$i ?>"><?=$i ?></option>
        						<?php }	?>
        					</select>&nbsp;月&nbsp;&nbsp;
        					<select class="form-control" id="day" name="day">
        						<option value="">日</option>        						
        						<?php for($i = 1; $i <= 31; $i++){ ?>
            					<option value="<?=$i ?>"><?=$i ?></option>
        						<?php }	?>
        					</select>&nbsp;日&nbsp;&nbsp;
        				</td>
        			</tr>
        			<tr>	
        				<th>電話番号：</th>
        				<td><input class="form-control" type="text" id="userPhoneNumber" name="userPhoneNumber" placeholder="電話番号を入力してください。" ></td>
        			</tr>
        			<tr>	
        				<th>E-メール：</th>
        				<td class="form-inline">
        					<input class="form-control col-sm-8" type="email" id="userEmail" name="userEmail" placeholder="E-メールを入力してください。">&nbsp;
        					<button type="button" class="btn btn-default" onclick="userEmailCheck();">重複チェック</button>
        				</td>
        			</tr>
        			<tr>	
        				<th>住所：</th>
        				<td class="form-inline">
        					<input class="form-control col-sm-4" type="text" id="userZipCode" name="userZipCode" placeholder="郵便番号">&nbsp;
        					<button type="button" class="btn btn-default" onclick="searchZipCode();">検索</button>
        				</td>
        			</tr>
        			<tr>
        				<td></td>
        				<td><input class="form-control" type="text" id="userAddress1" name="userAddress1" placeholder="都道府県"></td>
        			</tr>
        			<tr>
        				<td></td>
        				<td><input class="form-control" type="text" id="userAddress2" name="userAddress2" placeholder="詳細住所を入力してください。（選択）"></td>
        			</tr>
        		</table>
            	<div class="div-right">
            		<button type="submit" name="insertUser" class="btn btn-primary">会員登録</button>
            		<button type="button" class="btn btn-danger" onclick="history.back();">取消</button>
        		</div>
    		</form>
    	</div>
    	<div class="col-lg-4"></div>
	</div>
	
	
	
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="../js/user.js"></script>


</body>
</html>