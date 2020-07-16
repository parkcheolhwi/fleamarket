<?php session_start();?>
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
<style>
ul {
    list-style:none;
    margin:0;
    padding:0;
}

li {
    margin: 0 10px 0 0;
    padding: 0 0 0 0;
    border : 0;
    float: left;
}
</style>

</head>
<body>

	<?php require_once '../menu/menunav.php';?>

	<div class="container" style="margin-top:50px">	
		<hr>
		<div>
    		<h4 class="text-dark font-weight-bold" style="float:left;">商品リスト<span id="goodsAreaList"></span></h4>
    		<?php if(isset($_SESSION['userInfo'])){?>
    		<button type="button" class="btn btn-primary" style="float:right;" onclick="openGoodsInsertModal();">登録</button>
    		<?php }?>
    		<input class="form-control col-sm-2" type="text" name="goodsSearch" id="goodsSearch" placeholder="Search" aria-label="Search" style="float:right;" onkeyup="goodsAllList();">
			<select class="form-control col-sm-3" style="float:right; margin-right:10px;" id="goodsAreaSelect" name="goodsAreaSelect">
				<option value="">地域を選択してください。</option>
				<option value="東京">東京</option>
				<option value="大阪">大阪</option>
				<option value="北海道">北海道</option>
			</select>
		</div>
		<!-- 商品リスト -->
		<div style="clear:both" id="goodsDiv"></div>
	</div>
	
	<!-- 商品登録MODAL -->
	<div class="modal" id="goodsInsertModal">
		<div class="modal-dialog modal-lg">
			<form id="goodsInsertForm" name="goodsInsertForm">
    			<div class="modal-content">
    				<input type="hidden" id="userNo" name="userNo" value="<?=$_SESSION['userInfo']['user_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">商品登録</h4>
                        <button type="button" class="close goodsInsertModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                		<div class="md-form">
                         	<input type="text" class="form-control" id="goodsTitle" name="goodsTitle">
                         	<label for="goodsTitle" class="text-dark font-weight-bold">タイトル</label>
                        </div>
                        <div style=" display: flex;flex-direction: row">
                            <div class="md-form" style="margin: 2px; padding: 5px; flex: 0 1 50%;">
                             	<select class="browser-default custom-select" id="goodsArea" name="goodsArea">
                                    <option value="東京">東京</option>
                                    <option value="大阪">大阪</option>
                                    <option value="北海道">北海道</option>
    							</select>
                            </div>
                            <div class="md-form" style="margin: 2px; padding: 5px; flex: 0 1 50%;">
                             	<input type="text" class="form-control" id="goodsPrice" name="goodsPrice">
                             	<label for="goodsPrice" class="text-dark font-weight-bold">価格</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goodsContent">Content</label>
                            <textarea class="form-control" id="goodsContent" name="goodsContent" rows="5"></textarea>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                           		<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="goodsFile" name="goodsFile" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="goodsFile">Choose file</label>
                            </div>
                            <button type="button" class="btn btn-primary" style="margin: 0 0 0 10px;">ファイル追加</button>
                        </div>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="goodsInsert();">登録</button>
                   		<button type="button" class="btn btn-danger goodsInsertModalClose" data-dismiss="modal">取消</button>
                    </div>
    			</div>
			</form>
		</div>
	</div>

<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../js/goods.js"></script>
<script src="../js/cart.js"></script>
<script>
$(document).ready(function(){
	goodsAllList();
});
</script>
</body>
</html>