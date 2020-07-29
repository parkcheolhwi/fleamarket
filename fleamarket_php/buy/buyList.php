<?php
session_start();
require_once '../db/connection.php';
require_once './buy.inc';
$model = new BuyModel();
$model -> processing();
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
			<?php if(count($model->getBuyList()) == 0){?>
			<div style="text-align:center" >
				<h3 class="text-success font-weight-bold">内訳がありません。</h3>
			</div>
			<?php }?>
			
			<?php for($i = 0; $i < count($model->getBuyList()); $i++){?>
		    <hr>
			<div style="display: flex;flex-direction: row">
    			<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    				<img src="../upload/<?php $model->getBuyList()[$i]['goods_filerealname'] == null ? print "noImg.jpg" : print $model->getBuyList()[$i]['goods_filerealname'] ?>" style="max-height: 74px; max-width: 74px">
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 60%;">
        			<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no=<?=$model->getBuyList()[$i]['goods_no'] ?>"><?=$model->getBuyList()[$i]['goods_title'] ?></a></h5>
        			<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$model->getBuyList()[$i]['goods_price'] ?>円</span></p>
        			<p style="margin:0"><span class="text-dark"><?=$model->getBuyList()[$i]['goods_content'] ?></span></p>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 30%; text-align:right;">
        			<p style="margin-bottom:10px">購入日：<?=$model->getBuyList()[$i]['buy_createdate'] ?></p>
    			</div>
			</div> 
		    <?php }?>
		</div>
	</div>

<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/fleamarket.js"></script>
</body>
</html>