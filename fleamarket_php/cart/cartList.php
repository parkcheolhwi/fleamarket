<?php 
session_start();
require_once '../db/connection.php';
require_once './cart.inc';
$model = new CartModel();
$model -> processing();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>カートリスト|フリマシステム</title>
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
            <p style="margin:0; "><button type="button" class="btn btn-primary btn-sm " onclick="buyInsertCheck();">購入</button></p>
		</div>
		<div style="clear:both"></div>
		<!-- カートリスト -->
		<div>
			<?php if(count($model->getCartList())==0){?>
			<div style="text-align:center" >
				<h3 class="text-success font-weight-bold">内訳がありません。</h3>
			</div>
			<?php }?>
			
			<?php for($i = 0; $i < count($model->getCartList()); $i++){?>
			<hr>
			<div style="display: flex;flex-direction: row">
    			<div style="margin: 2px; padding: 5px; flex: 0 1 10%;">
    				<?php if(isset($model->getCartList()[$i]['goods_filerealname'])){ ?>
    					<img src="../upload/<?=$model->getCartList()[$i]['goods_filerealname'] ?>" style="max-height: 74px; max-width: 74px">
    				<?php }else{?>
    					<img src="../upload/noImg.jpg" style="max-height: 74px; max-width: 74px">
    				<?php }?>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 60%;">
        			<h5 style="margin:0" class="text-dark font-weight-bold"><a href="../goods/goodsDetail.php?goods_no=<?=$model->getCartList()[$i]['goods_no'] ?>"><?=$model->getCartList()[$i]['goods_title'] ?></a></h5>
        			<p style="margin-bottom:10px"><span class="text-dark font-weight-bold"><?=$model->getCartList()[$i]['goods_price'] ?></span></p>
        			<p style="margin:0"><span class="text-dark"><?=$model->getCartList()[$i]['goods_content'] ?></span></p>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 25%; text-align:right;">
        			<p style="margin-bottom:10px">カート登録：<?=$model->getCartList()[$i]['cart_createdate'] ?></p>
        			<div class="form-inline" style="float:right;">
            			<p style="margin:0; "><button type="button" class="btn btn-outline-danger" onclick="cartDelete(<?=$model->getCartList()[$i]['cart_no'] ?>)">削除</button></p>
        			</div>
    			</div>
    			<div style="margin: 2px; padding: 5px; flex: 0 1 5%; text-align:right;">
        			<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="goodsChecked" id="goodsChecked<?=$model->getCartList()[$i]['cart_no'] ?>" value="<?=$model->getCartList()[$i]['goods_no']?>">
                        <label class="custom-control-label" for="goodsChecked<?=$model->getCartList()[$i]['cart_no'] ?>"></label>
                    </div>
    			</div>
			</div> 
			<?php }?>
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
<script src="../btjs/fleamarket.js"></script>
</body>
</html>