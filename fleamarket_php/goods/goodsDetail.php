<?php 
session_start();

if(isset($_SESSION['recentlyViewedGoods'])){
    $check = true;
    foreach($_SESSION['recentlyViewedGoods'] as $key => $value){
        if($_SESSION['recentlyViewedGoods'][$key] == $_GET['goods_no']){
            unset($_SESSION['recentlyViewedGoods'][$key]);
            $_SESSION['recentlyViewedGoods'][] = $_GET['goods_no'];
            $check = false;
            break;
        }
    }
    if($check){
        $_SESSION['recentlyViewedGoods'][] = $_GET['goods_no'];
    }
}

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

$sql = "SELECT * FROM goods_file WHERE goods_no = {$detailGoodsData['goodsNo']}";
$fileResult = mysqli_query($conn, $sql);


$sql = "
        SELECT
            d.*, count(e.user_likecount) AS user_likecount, count(e.user_hatecount) AS user_hatecount
            FROM (
                SELECT
                    a.*, b.user_id, c.goods_filerealname
                    FROM
                        goods a
                    INNER JOIN
                        userinfo b
                    ON
                        a.user_no = b.user_no
                    LEFT JOIN
					    goods_file c
                    ON a.goods_no = c.goods_no
                    GROUP BY
                        a.goods_no
                 ) d
                LEFT JOIN
                    like_hate_count e
                ON
                    d.user_no = e.user_no
                WHERE
                    d.goods_no = {$detailGoodsData['goodsNo']}
                GROUP BY
                    d.user_no
                    
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
<title>商品紹介|フリマシステム</title>
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
    		<form action="../chat/chatDetail.php" method="post">
    			<input type="hidden" name="user_id" value="<?=$data['user_id']?>">
        		<table class="table" style="text-align:center;">
        			<tr>
        				<td style="width:15%">出品者：</td>
        				
        				<td style="width:35%"><?=$data['user_id'] ?>
        					<?php if(isset($_SESSION['userInfo']) && $data['user_no'] != $_SESSION['userInfo']['user_no']){?>
        					<button type="submit" class="btn btn-outline-info btn-sm">メッセージする</button>
	        				<?php }?>
        				</td>
        				<td rowspan="4" colspan="2">
        					<?php 
        					   if(mysqli_num_rows($fileResult) > 0){
        					   ?>
        					<div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  								<div class="carousel-inner">
    							
								<?php
								    $count = 0;
								    while($fileData = mysqli_fetch_assoc($fileResult)){
							        if($count == 0){
						        ?>
							        <div class="carousel-item active">
                                   		<img class="d-block w-100" src="../upload/<?=$fileData['goods_filerealname']?>" >
                                	</div>
								<?php }?>
                      	    		<div class="carousel-item">
                                       <img class="d-block w-100" src="../upload/<?=$fileData['goods_filerealname']?>" >
                                    </div>
                              	<?php 
                              	     $count++;
								     }
							     ?>
  								</div>
                                  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                            </div>

        					<?php }else{?>
        						<img src="../upload/noImg.jpg" style="max-height: 150px; max-width: 150px">
        					<?php }?>
    					   

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
        				<td><button type="button" class="btn btn-outline-danger"  onclick="userHateCountButton('<?=$data['user_no'] ?>')" >悪い</button></td>
        		 		<td><button type="button" class="btn btn-outline-primary" onclick="insertIntoCart('<?=$data['goods_no'] ?>')">カートに入れる</button></td>
        				<td><button type="button" class="btn btn-outline-primary" onclick="buyInsertCheck();">購入</button></td>
        				
        			</tr>
        			<tr>
        				<td colspan="4"></td>
        			</tr>
        		</table><br>
    		</form>
		
    		<div>
        		<!-- コメントリスト -->
    			<div><span>コメント</span></div>
				<div id="goodsCommentList"></div>
			
				<form onsubmit="commentManager.insert(this); return false;">
					<input type="hidden" id="userNo" name="userNo" value="<?php isset($_SESSION['userInfo']['user_no']) ? print $_SESSION['userInfo']['user_no'] : print "" ?>">
    				<div>
    					<textarea class="form-control" id="goodsCommentContent" name="goodsCommentContent" rows="2"></textarea>	
    					<button type="submit" class="btn btn-light">コメント</button>
    				</div>
				</form>
    		</div>
        </div>
        <!-- id="insertComment" -->
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
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">商品削除</h4>
                        <button type="button" class="close ModalClose" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                    	<h5 class="font-weight-bold text-danger">商品を削除しますか？</h5>
                		<div class="md-form">
                         	<input type="password" class="form-control" id="userPassword2" name="userPassword2">
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
    				<input type="hidden" id="goodsCmd" name="goodsCmd" value="update">
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
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="goodsFile" name="goodsFile[]" aria-describedby="inputGroupFileAddon01" multiple="multiple">
                                <label class="custom-file-label" for="goodsFile">ファイルを選択してください。</label>
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
                <?php if(isset($_SESSION['userInfo'])){?>
                <div class="modal-footer">
                	<button type="button" class="btn btn-primary" onclick="goodsBuy();">購入</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
                <?php } else { ?>
                <div class="modal-footer">
                	<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">非会員購入</button>
                	<button type="button" class="btn btn-success" onclick="location.href='../user/login.php'">ログインする</button>
               		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
                <?php }?>
                
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
    					<div class="card card-body">
    						<div class="md-form form-sm" style="margin:0">
            					<input class="form-control" type="text" id="userName" name="userName" value="">&nbsp;
            					<label for="userName">名前を入力してください。</label>
            				</div>
            				<div class="md-form form-sm">
            					<input class="form-control form-control-sm" type="password" id="userPassword" name="userPassword" value="">
            					<label for="userPassword">PassWordを入力してください。</label>
            				</div>
            				<div class="md-form form-sm">
            					<input class="form-control form-control-sm" type="password" id="userPasswordCheck" name="userPasswordCheck" value="">
            					<label for="userPasswordCheck">PassWord(確認)を入力してください。</label>
            					<span id="passwordCheckResult"></span>
            				</div>
            				<div class="md-form form-sm form-inline" style="margin:0">
								<input class="form-control form-control-sm col-sm-8" type="email" id="userEmail" name="userEmail" value="">&nbsp;
            					<label for="userEmail">E-メールを入力してください。</label>
            					<button type="button" class="btn btn-default" onclick="userEmailCheck();">重複チェック</button>
            				</div>
            				<div class="md-form form-sm form-inline">
            					<input class="form-control form-control-sm col-sm-4" type="text" id="userZipCode" name="userZipCode" value="">&nbsp;
            					<label for="userZipCode">郵便番号</label>
            					<button type="button" class="btn btn-default" onclick="searchZipCode();">検索</button>
            				</div>
            				<div class="md-form form-sm">
            					<input class="form-control form-control-sm" type="text" id="userAddress1" name="userAddress1" value="">
            					<label for="userAddress1">都道府県</label>
            				</div>
            				<div class="md-form form-sm">
            					<input class="form-control form-control-sm" type="text" id="userAddress2" name="userAddress2" value="">
            					<label for="userAddress2">詳細住所を入力してください。（選択）</label>
            				</div>
            				<div class="div-right">
                        		<button type="submit" name="insertUser" class="btn btn-primary" onclick="nonUserBuy(<?=$data['goods_no'] ?>);">非会員購入</button>
                        		<button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    		</div>
    					</div>
                    </div>
                
			</div>
		</div>
	</div>
<script src="../btjs/jquery.min.js"></script>
<script src="../btjs/popper.min.js"></script>
<script src="../btjs/bootstrap.min.js"></script>
<script src="../btjs/mdb.min.js"></script>
<script src="../btjs/fleamarket.js"></script>
<script>
$(document).ready(function(){
	commentManager.list(<?=$data['goods_no'] ?>, <?php isset($_SESSION['userInfo']['user_no']) ? print $_SESSION['userInfo']['user_no'] : print ""?>);
});
</script>
</body>
</html>