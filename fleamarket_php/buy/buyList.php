<?php
session_start();
if(!isset($_SESSION['userInfo'])){
    $errorMsg = "ログインしてください。";
    $path = "login";
    header("Location: ../error.php?errorMsg={$errorMsg}&path={$path}");
    exit;
}

/**
 * 商品リストを検索して表示
 * @var unknown $conn
 */
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
            buy.buy_no, 
            buy.user_no, 
            buy.goods_no, 
            buy.buy_createdate, 
            goods.goods_no,
            goods.goods_title, 
            goods.goods_price, 
            goods.goods_content,
            goods_file.goods_filerealname
            FROM 
                buy 
                INNER JOIN 
                    goods 
                ON 
                    buy.goods_no = goods.goods_no
                LEFT JOIN
                    goods_file
                    ON 
                        goods.goods_no = goods_file.goods_no
            WHERE buy.user_no = {$_SESSION['userInfo']['user_no']}
        ";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>購入リスト|フリマシステム</title>
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
    		<h4 class="text-dark font-weight-bold" style="float:left;">購入リスト</h4>
		</div>
		<!-- 購入リスト -->
		<div style="clear:both">
			<?php 
			if(mysqli_num_rows($result) > 0){
			    while($row = mysqli_fetch_assoc($result)){
			?>
			<hr>
			<div style="display: flex;flex-direction: row">
    			<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    				<img src="../upload/<?php $row['goods_filerealname'] == null ? print "noImg.jpg" : print $row['goods_filerealname'] ?>" style="max-height: 74px; max-width: 74px">
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 60%;">
        			<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no=<?=$row['goods_no'] ?>"><?=$row['goods_title'] ?></a></h5>
        			<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$row['goods_price'] ?>円</span></p>
        			<p style="margin:0"><span class="text-dark"><?=$row['goods_content'] ?></span></p>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 30%; text-align:right;">
        			<p style="margin-bottom:10px">購入日：<?=$row['buy_createdate'] ?></p>
    			</div>
			</div> 
		
			
			
			<?php 
			    }
			    mysqli_free_result($result);
			    mysqli_close($conn);
			} else {
			?>
			<div style="text-align:center" >
				<h3 class="text-success font-weight-bold">内訳がありません。</h3>
			</div>
			<?php 
			}
			?>
		</div>
	</div>

<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/cart.js"></script>	
</body>
</html>