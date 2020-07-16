<?php session_start();


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
    		<h4 class="text-dark font-weight-bold" style="float:left;">購入リスト</h4>

    		<input class="form-control col-sm-4" type="text"  placeholder="Search" aria-label="Search" style="float:right;">
		</div>
		<!-- カートリスト -->
		<div style="clear:both">
			
			<hr>
			<div style="display: flex;flex-direction: row">
    			<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    				<img src="../img/123.jpg" style="max-height: 74px; max-width: 74px">
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 60%;">
        			<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no=111">제목</a></h5>
        			<p style="margin-bottom:10px"><span class="text-dark font-weight-bold">1000円</span></p>
        			<p style="margin:0"><span class="text-dark">내용</span></p>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 30%; text-align:right;">
        			<p style="margin-bottom:10px">購入日：2020-03-03</p>
    			</div>
			</div> 
		
			
			<div style="text-align:center" >
				<h3 class="text-success font-weight-bold">内訳がありません。</h3>
			</div>
			
			
		</div>
	</div>

<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../js/cart.js"></script>	
</body>
</html>