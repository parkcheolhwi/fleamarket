<?php session_start();
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
            cart.cart_no, cart.user_no, cart.cart_createdate, goods.*
            FROM
                cart
            INNER JOIN
                goods
            ON
                cart.goods_no = goods.goods_no
            WHERE 
                cart.user_no = {$_SESSION['userInfo']['user_no']}
        ";

$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フリマシステム</title>
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
    		<h4 class="text-dark font-weight-bold" style="float:left;">カートリスト</h4>
		</div>
		<div style="clear:both"></div>
		<div style="float:right;" class="form-inline" >
			<br>
			<div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultChecked">
                <label class="custom-control-label text-dark font-weight-bold" for="defaultChecked">전체선택</label>
            </div>
            <p style="margin:0; "><button type="button" class="btn btn-primary btn-sm " onclick="cartInserCheck();">購入</button></p>
		</div>
		<div style="clear:both"></div>
		<!-- カートリスト -->
		<div >
			<?php 
			if(mysqli_num_rows($result) > 0){
			    while($row = mysqli_fetch_assoc($result)){
			?>
			<hr>
			<div style="display: flex;flex-direction: row">
    			<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    				<img src="../img/123.jpg" style="max-height: 74px; max-width: 74px">
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 60%;">
        			<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no=<?=$row['goods_no'] ?>"><?=$row['goods_title'] ?></a></h5>
        			<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$row['goods_price'] ?></span></p>
        			<p style="margin:0"><span class="text-dark"><?=$row['goods_content'] ?></span></p>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 25%; text-align:right;">
        			<p style="margin-bottom:10px">カート登録：<?=$row['cart_createdate'] ?></p>
        			<div class="form-inline" style="float:right;">
            			<p style="margin:0; "><button type="button" class="btn btn-outline-danger" onclick="cartDelete(<?=$row['cart_no'] ?>)">削除</button></p>
        			</div>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 5%; text-align:right;">
        			<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="goodsChecked" id="goodsChecked<?=$row['cart_no'] ?>" value="<?=$row['goods_no']?>">
                        <label class="custom-control-label" for="goodsChecked<?=$row['cart_no'] ?>"></label>
                    </div>
    			</div>
			</div> 
			<?php         
			    }
			}else{
			?>
			<div style="text-align:center" >
				<h3 class="text-success font-weight-bold">内訳がありません。</h3>
			</div>
			<?php     
			}
			?>
			
		</div>
	</div>


	<!-- 購入確認Modal -->
	<div class="modal" id="cartBuyCheckModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">購入</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                	<div class="text-primary">下記の商品を購入しますか？</div>
            		<div id="cartBuyCheckList"></div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                	<button type="button" class="btn btn-primary" onclick="goodsBuy();">購入</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
			</div>
		</div>
	</div>
	
	
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/cart.js"></script>	
</body>
</html>