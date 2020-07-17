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

$detailGoodsData = array(
    'goodsNo' => mysqli_real_escape_string($conn, $_GET['goods_no']),
    
);

$sql = "
        SELECT 
            c.*, count(d.user_likecount) AS user_likecount, count(d.user_hatecount) AS user_hatecount 
            FROM (
                SELECT 
                    a.*, b.user_id  
                    FROM  
                        goods a 
                    INNER JOIN 
                        userinfo b  
                    ON 
                        a.user_no = b.user_no
                 ) c 
                LEFT JOIN 
                    like_hate_count d 
                ON 
                    c.user_no = d.user_no  
                WHERE 
                    c.goods_no = {$detailGoodsData['goodsNo']} 
                GROUP BY 
                    c.user_no
        
        ";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
}
mysqli_free_result($result);
mysqli_close($conn);
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
</head>
<body>

	<?php require_once '../menu/menunav.php';?>

	<div class="container" style="margin-top:50px">
		<div><h2 class="font-weight-bold"><?=$data['goods_title'] ?></h2></div>
                    			
        <div>
        	<form id="goodsDetailForm">
        		<input type="hidden" name="goodsNo" value="<?=$data['goods_no'] ?>">
    		</form>
        	<div style="text-align:right;">
    			登録日：<?=$data['goods_createdate'] ?>, 
    			修正日：<?=$data['goods_updatedate'] ?>
    		</div>
    		<table class="table" style="text-align:center;">
    			<tr>
    				<td style="width:15%">出品者：</td>
    				<td style="width:35%"><?=$data['user_id'] ?><button type="button" class="btn btn-outline-info btn-sm" onclick="#">메세지하기</button></td>
    				<td rowspan="4" colspan="2">
    					<img src="../img/123.jpg" style="max-height: 150px; max-width: 150px">
    				</td>
    			</tr>
    			<tr>
    				<td>いいね：<span id="userLikeCount"><?=$data['user_likecount'] ?></span></td>
    				<td>悪い：<span id="userHateCount"><?=$data['user_hatecount'] ?></span></td>
    			</tr>
    			<tr>
    				<td>地域：</td>
    				<td><?=$data['goods_area'] ?></td>
    			</tr>
    			<tr>
    				<td>価格：</td>
    				<td><?=$data['goods_price'] ?>円</td>
    			</tr>
    			<tr>
    				<td colspan="4" style="text-align:left" ><?=$data['goods_content'] ?></td>
    			</tr>
    			
    			<tr>
    				<td><button type="button" class="btn btn-outline-info" onclick="userLikeCountButton('<?=$data['user_no'] ?>')">いいね</button></td>
    				<td><button type="button" class="btn btn-outline-danger"  onclick = "userHateCountButton('<?=$data['user_no'] ?>')" >悪い</button></td>
    		 		<td><button type="button" class="btn btn-outline-primary" onclick="insertIntoCart('<?=$data['goods_no'] ?>')">カートに入れる</button></td>
    				<td><button type="button" class="btn btn-outline-primary" onclick="buyInserCheck();">購入</button></td>
    			</tr>
    			<tr>
    				<td colspan="4"></td>
    			</tr>
    		</table><br>
    		    		
    		<div>
        		<!-- コメントリスト -->
    			<div><span>コメント</span></div>
				<div id="goodsCommentList"></div>
				<hr>
				<form id="goodsCommentForm" name="goodsCommentForm">
					<input type="hidden" id="goodsNo" name="goodsNo" value="<?=$data['goods_no'] ?>">
					<input type="hidden" id="userNo" name="userNo" value="<?php isset($_SESSION['userInfo']['user_no']) ? print $_SESSION['userInfo']['user_no'] : print "" ?>">
    				<div>
    					<textarea class="form-control" id="goodsCommentContent" name="goodsCommentContent" rows="2"></textarea>	
    					<button type="button" class="btn btn-light" id="insertComment">コメント</button>
    				</div>
				</form>
    		</div>
        </div>
        
       <?php if(isset($_SESSION['userInfo']) && $_SESSION['userInfo']['user_no'] == $data['user_no']){?>
        <div style="text-align:right;">
        	<button type="button" class="btn btn-outline-info" onclick="goodsUpdateModal()">更新</button>
        	<button type="button" class="btn btn-outline-info" onclick="goodsDeleteModal()">削除</button>
        </div>
		<?php }?>
	</div>
	


    <!-- 削除MODAL -->
	<div class="modal" id="goodsDeleteModal">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<form id="goodsDeleteForm" name="goodsDeleteForm">
    				<input type="hidden" id="goodsNo" name="goodsNo" value="<?=$data['goods_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">商品削除</h4>
                        <button type="button" class="close ModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<h5 class="font-weight-bold text-danger">商品を削除しますか？</h5>
                		<div class="md-form">
                         	<input type="password" class="form-control" id="userPassword" name="userPassword">
                         	<label for="userPassword" class="text-dark font-weight-bold">パスワード</label>
                        </div>
                    </div>
        
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="goodsDelete();">削除</button>
                   		<button type="button" class="btn btn-danger ModalClose" data-dismiss="modal">取消</button>
                    </div>
                </form>
			</div>
		</div>
	</div>


	<!-- 商品更新MODAL -->
	<div class="modal" id="goodsUpdateModal">
		<div class="modal-dialog modal-lg">
			<form id="goodsUpdateForm" name="goodsUpdateForm">
    			<div class="modal-content">
    				<input type="hidden" id="goodsNo" name="goodsNo" value="<?=$data['goods_no'] ?>">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">商品更新</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                		<div class="md-form">
                         	<input type="text" class="form-control" id="goodsTitle" name="goodsTitle" value="<?=$data['goods_title'] ?>">
                         	<label for="goodsTitle" class="text-dark font-weight-bold">タイトル</label>
                        </div>
                        <div style=" display: flex;flex-direction: row">
                            <div class="md-form" style="margin: 2px; padding: 5px; flex: 0 1 50%;">
                             	<select class="browser-default custom-select" id="goodsArea" name="goodsArea">
                                    <option value="東京" <?php if($data['goods_area'] == '東京') echo "selected"?> >東京</option>
                                    <option value="大阪" <?php if($data['goods_area'] == '大阪') echo "selected"?>>大阪</option>
                                    <option value="北海道" <?php if($data['goods_area'] == '北海道') echo "selected"?>>北海道</option>
    							</select>
                            </div>
                            <div class="md-form" style="margin: 2px; padding: 5px; flex: 0 1 50%;">
                             	<input type="text" class="form-control" id="goodsPrice" name="goodsPrice" value="<?=$data['goods_price'] ?>">
                             	<label for="goodsPrice" class="text-dark font-weight-bold">価格</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="goodsContent">Content</label>
                            <textarea class="form-control" id="goodsContent" name="goodsContent" rows="5"><?=$data['goods_content'] ?></textarea>
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
                    	<button type="button" class="btn btn-primary" onclick="goodsUpdate()">更新</button>
                   		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
    			</div>
			</form>
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
<script src="../btjs/mdb.min.js"></script>
<script src="../js/goods.js"></script>
<script src="../js/user.js"></script>
<script src="../js/cart.js"></script>
<script>
$(document).ready(function(){
	goodsComment();
});
</script>
</body>
</html>